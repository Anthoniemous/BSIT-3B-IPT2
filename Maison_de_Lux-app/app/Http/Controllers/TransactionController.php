<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Customer can view their own transactions
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with(['order', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('user.transactions.index', compact('transactions'));
    }

    // Customer can view their own transaction details
    public function show($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())
            ->with(['order.orderItems.product', 'user'])
            ->findOrFail($id);

        return view('user.transactions.show', compact('transaction'));
    }
}