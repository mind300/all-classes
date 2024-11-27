<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::get();
        return contentResponse($transactions->load('subscription_plans'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return contentResponse($transaction->load('subscription_plans'));
    }
}
