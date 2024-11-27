<?php

namespace App\Http\Controllers\Api\Cards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cards\CardPrimaryRequest;
use App\Models\Card;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = Card::where('user_id', auth_user_id())->get();
        return contentResponse($cards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CardPrimaryRequest $request)
    {
        $cardPrimary = Card::find($request->validated('card_id'))->update(['primary' => 1]);
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        return contentResponse($card);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        $card->forceDelete();
        return messageResponse();
    }
}
