<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Create a new PostController instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'list']);
    }

    /**
     * Create the user post
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $post = new Post();
        $post->user_id = auth()->user()->id;
        $post->title = $request->post('title');
        $post->content = $request->post('content');
        $post->save();

        return response()->json([
            'message' => 'Successfully created post'
        ]);
    }

    /**
     * Get all posts created user
     *
     * @return JsonResponse
     */
    public function listAuth()
    {
        $data = [];
        foreach (auth()->user()->posts as $post) {
            $data[] = $post;
        }

        return response()->json($data);
    }

    /**
     * Get all posts
     *
     * @return JsonResponse
     */
    public function list()
    {
        return response()->json(Post::all());
    }
}
