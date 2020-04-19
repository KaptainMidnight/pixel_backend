<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Create the user post
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $data = [];
        foreach (auth()->user()->posts as $post) {
            $data[] = $post;
        }

        return response()->json($data);
    }
}
