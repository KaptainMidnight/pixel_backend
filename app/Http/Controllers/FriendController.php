<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * Send friend request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function send(Request $request)
    {
        $sender = User::query()->find(auth()->user()->id);
        $recipient = User::query()->findOrFail($request->post('recipient_id'));
        $sender->befriend($recipient);

        return response()->json([
            'message' => 'Sended'
        ]);
    }

    /**
     * Accept user request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function accept(Request $request)
    {
        $user = User::query()->find(auth()->user()->id);
        $sender = User::query()->findOrFail($request->get('sender_id'));

        $user->acceptFriendRequest($sender);

        return response()->json([
            'message' => 'Accepted'
        ]);
    }

    /**
     * Get all accepted friendships
     *
     * @return JsonResponse
     */
    public function getAllFriendships()
    {
        $sender = User::query()->find(auth()->user()->id);

        return response()->json($sender->getFriends());
    }

    /**
     * Leave it to subscribers
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function denyFriendRequest(Request $request)
    {
        $recipient = User::query()->findOrFail(auth()->user()->id);
        $sender = $request->post('sender_id');

        $recipient->denyFriendRequest($sender);

        return response()->json([
            'message' => 'Denied!',
            'code' => 200,
        ]);
    }

    /**
     * Move user in subscribers
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function unFriend(Request $request)
    {
        $user = auth()->user()->id;
        $recipient = $request->post('recipient_id');

        $user->unfriend($recipient);

        return response()->json([
            'message' => 'Unfriended!',
            'code' => 200,
        ]);
    }
}
