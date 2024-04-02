<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustSentController extends Controller
{
    public function index()
    {
        return view('admin.moneySent');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cust_id' => 'required',
            'amount' => 'required',
            'rate' => 'required',
            'transaction_type' => 'required',
            'transaction_id' => 'required',
            'transDate' => 'required',

        ]);

        return redirect()->back()->with('success', 'Money Received Successfully');
    }
}
