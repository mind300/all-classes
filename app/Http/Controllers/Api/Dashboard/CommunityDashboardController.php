<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\User;

class CommunityDashboardController extends Controller
{
    // All Counts For Community
    public function communityDashboard()
    {
        $forms = User::with('member')->where('is_active', 0)->count();
        $admins = User::whereHasRole('admin')->count();
        $members = User::with('member')->where('is_active', 1)->count();

        $membersChart = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('status', 1)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $rwwardsChart = Reward::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $response = [
            'forms' => $forms,
            'admins' => $admins,
            'members' => $members,
            'membersChart' => $membersChart,
            'rwwardsChart' => $rwwardsChart,
        ];

        return contentResponse($response);
    }
}
