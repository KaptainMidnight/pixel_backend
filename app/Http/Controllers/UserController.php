<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Response all users
     *
     * @return JsonResponse
     */
    public function list()
    {
        return response()->json(User::query()->where('id', '<>', auth()->user()->id)->get());
    }
}
