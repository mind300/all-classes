<?php

namespace App\Http\Controllers\Api\Home;
use App\Http\Controllers\Controller;

// Models
use App\Models\BuySell;
use App\Models\Charity;
use App\Models\Event;
use App\Models\Job;
use App\Models\News;
use App\Models\Offer;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = [
            'news' => News::limit(1)->latest()->first(),
            'events' =>  Event::limit(1)->latest()->first(),
            'jobs' => Job::with('user')->limit(1)->latest()->first(),
            'charties' => Charity::limit(1)->latest()->first(),
            'offers' => Offer::limit(1)->latest()->first(),
            'buy_sells' => BuySell::with('user')->limit(1)->latest()->first(),
        ];
        return contentResponse($response);
    }
}
