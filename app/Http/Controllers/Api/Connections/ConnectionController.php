<?php

namespace App\Http\Controllers\Api\Connections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Connections\ConnectionRequest;
use App\Models\Member;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    /**
     * Display all members
     */
    public function index(Request $request)
    {
        $auth = auth_user()->member;

        $query = Member::with('media', 'user');

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;

            // Filter by user attributes (name or email, for example)
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        $members = $query->get();

        $connections = $members->transform(function ($member) use ($auth) {
            $member->is_followed = $member->followers->contains(function ($follow) use ($auth) {
                return $follow->pivot->followed_id === $auth->id;
            });
            return $member;
        });

        // Return the response, hiding the 'followers' field to prevent exposing sensitive data
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
        return contentResponse($connection->load('media', 'user')->setHidden(['following']));
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
