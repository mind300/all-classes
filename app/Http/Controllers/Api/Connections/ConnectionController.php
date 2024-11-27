<?php

namespace App\Http\Controllers\Api\Connections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Connections\ConnectionRequest;
use App\Models\Member;

class ConnectionController extends Controller
{
    /**
     * Display all members
     */
    public function index()
    {
        $auth = auth_user()->member;
        $members = Member::get();

        $connections = $members->transform(function ($member) use ($auth) {
            // Check if the authenticated user follows this member
            $member->is_followed = $member->followers->contains(function ($follow) use ($auth) {
                return $follow->pivot->followed_id === $auth->id;
            });
            return  $member;
        });

        return contentResponse($connections->setHidden(['followers']));
    }

    /**
     * Display  member
     */
    public function show(Member $connection)
    {
        $auth = auth_user()->member;

        $connection->is_followed = $connection->following->contains(function ($follow) use ($auth) {
            return $follow->pivot->follower_id === $auth->id;
        });

        return contentResponse($connection->load('user.jobs', 'user.buy_sells')->setHidden(['following']));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ConnectionRequest $request)
    {
        $followed = auth_user()->member;
        $follower = $request->follower_id;

        // If the auth member cant make follow for it self
        if ($followed == $follower) return messageResponse('Cant make follow for your self', false, 403);

        // Check if the authenticated member is already following the other user
        $connection = $followed->following()->where('follower_id', $follower)->first();

        // =========== Unfollow =========== //
        if ($connection) {
            $followed->following()->detach($follower);
            $followed->decrement('following_number');

            // Decrement the followers count for the user being unfollowed
            Member::find($follower)->decrement('followers_number');

            return contentResponse(['is_followed' => 0]);
        }

        // =========== Follow =========== //
        $followed->following()->attach($follower);
        $followed->increment('following_number');

        // Increment the followers count for the user being followed
        Member::find($follower)->increment('followers_number');

        return contentResponse(['is_followed' => 1]);
    }
}
