<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Reward;
use App\Models\User;

class MindDashboardController extends Controller
{
    // All Counts For Mind
    public function mindDashboard()
    {
        // $communities = Community::count();
        $admins = User::whereHasRole('admin')->count();

        $offers = Offer::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $suppliers = Brand::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return response()->json([
            'communities' => 0,
            'admins' => $admins,
            'offers' => $offers,
            'suppliers' => $suppliers,
        ]);
    }
}
