<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;

// Models
use App\Models\BuySell;
use App\Models\Charity;
use App\Models\Event;
use App\Models\JobAnnouncement;
use App\Models\Member;
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
            'news' => News::with('media', 'likes')->latest()->limit(3)->get(),
            'events' =>  Event::with('media')->latest()->limit(3)->get(),
            'jobs' => JobAnnouncement::with(['media','user.member.media'])->latest()->limit(3)->get(),
            'charties' => Charity::with('media')->latest()->limit(3)->get(),
            'offers' => Offer::with(['media','brand.media'])->latest()->limit(3)->get(),
            'buy_sells' => BuySell::with('media', 'user.member.media')->latest()->limit(3)->get(),
            'members' => Member::with('media')->latest()->limit(10)->get(),
        ];
        return contentResponse($response);
    }
}
