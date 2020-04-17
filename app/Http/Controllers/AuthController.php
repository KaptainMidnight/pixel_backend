<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signup']]);
    }

    /**
     * Get JWT via given credentials
     *
     * @return JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * User registration
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function signup(Request $request)
    {
        $validatorErrors = Validator::make($request->all(), [
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        if ($validatorErrors->fails()) {
            return response()->json($validatorErrors->failed());
        }

        $user = new User();
        $user->name = $request->post('name');
        $user->surname = $request->post('surname');
        $user->email = $request->post('email');
        $user->password = Hash::make($request->post('password'));
        $user->save();

        return response()->json([
            'message' => 'Succesfully registration'
        ]);
    }

    /**
     * Get user data via access token
     *
     * @return JsonResponse
     */
    public function show()
    {
        return response()->json(auth()->user());
    }

    /**
     * Unlogin user
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Refresh user token
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
