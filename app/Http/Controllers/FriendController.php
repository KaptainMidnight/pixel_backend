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
        $sender_id = User::query()->find(auth()->user()->id);
        $recipient_id = User::query()->findOrFail($request->post('recipient_id'));

        $sender_id->befriend((int)$recipient_id);

        return response()->json([
            'message' => 'Sended'
        ]);
    }

    /**
     * Deny friend request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deny(Request $request)
    {
        $sender_id = $request->post('sender_id');
        $recipient_id = auth()->user()->id;

        $recipient_id->denyFriendRequest($sender_id);

        return response()->json([
            'message' => 'Denied'
        ]);
    }

    /**
     * Get all friendships
     *
     * @return JsonResponse
     */
    public function friends()
    {
        return response()->json(auth()->user()->getFriends());
    }
}
