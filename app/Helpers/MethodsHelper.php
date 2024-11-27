<?php

use App\Models\InviteFriend;
use App\Models\PointHistory;
use App\Models\PointSystem;
use App\Models\User;

// Calculate Point Systems
if (!function_exists('point_system')) {
    function point_system($action, $isAuth = true, $id = null)
    {
        $points_system = PointSystem::firstWhere('action', $action);
        $user = auth_user_member();

        if (!$isAuth) {
            $user = User::find($id)?->member;
        }

        $pointHistory = PointHistory::create(['user_id' => $user->id, 'point_system_id' => $points_system->id]);
        return $user->increment('points', $points_system->points);
    }
}

// Calculate Point Systems
if (!function_exists('invite_friend')) {
    function invite_friend()
    {
        $user = auth_user();

        $inviteFriend = InviteFriend::firstWhere([
            'email' => $user->email,
            'mobile_number' => $user->member->mobile_number,
        ]);

        if ($inviteFriend) {
            point_system('invite_friend', false, $inviteFriend->user_id);
        }
    }
}
