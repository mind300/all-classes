<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;

// Models
use App\Models\BuySell;
use App\Models\Charity;
use App\Models\Event;
use App\Models\JobAnnouncement;
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
            'news' => News::with('media', 'likes')->limit(1)->latest()->first(),
            'events' =>  Event::with('media')->limit(1)->latest()->first(),
            'jobs' => JobAnnouncement::with('media')->limit(1)->latest()->first(),
            'charties' => Charity::with('media')->limit(1)->latest()->first(),
            'offers' => Offer::with('media')->limit(1)->latest()->first(),
            'buy_sells' => BuySell::with('media', 'user')->limit(1)->latest()->first(),
        ];
        return contentResponse($response);
    }
}
