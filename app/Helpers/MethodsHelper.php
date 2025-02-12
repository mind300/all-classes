<?php

use App\Models\InviteFriend;
use App\Models\PointHistory;
use App\Models\PointSystem;
use App\Models\User;
use Illuminate\Support\Facades\Config;

// Calculate Point Systems
if (!function_exists('point_system')) {
    function point_system($action, $isAuth = true, $id = null, $community_name = null)
    {
        if (auth_user()->hasRole('user')) {
            $points_system = PointSystem::firstWhere('action', $action);
            $database = Config::get('database.default');
            if ($database == 'suppliers') {
                $user = (new User)->setConnection($community_name)->find($id);
            } else {
                if (!$isAuth) {
                    $user = User::find($id);
                } else {
                    $user = auth_user_member();
                }
            }
            if (Config::get('database.default') == 'suppliers') {
                $pointHistory = (new PointHistory)->setConnection($community_name)->create(['user_id' => $user->id, 'point_system_id' => $points_system->id]);
                $user = $user->member;
                return $user->increment('points', $points_system->points);
            } else {
                $pointHistory = PointHistory::create(['user_id' => $user->user_id, 'point_system_id' => $points_system->id]);
            }
            return $user->increment('points', $points_system->points);
        }
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
