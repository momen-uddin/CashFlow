<?php

namespace App\Http\Controllers;

use App\Models\CustSents;
use Illuminate\Http\Request;

class CustSentController extends Controller
{
    public function index()
    {
        $combinedInfos = CustSents::with(['user'])
        ->get()->map(function ($item) {
            return [
                'cust_name' => $item->user->name,
                'cust_number' => $item->user->number,
                'trans_type' => $item->transaction_type,
                'trans_id' => $item->transaction_id,
                'amount' => $item->amount,

                'transDate' => $item->transDate,
                'rate' => $item->rate,
                // Add other fields from CustReceive model if needed
            ];
        });


        // Pass the combined information to the view
        return view('moneyCollect', compact('combinedInfos'));

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

        $custSent = CustSents::create([
            'cust_id' => $request->cust_id,
            'amount' => $request->amount,
            'rate' => $request->rate,
            'transaction_type' => $request->transaction_type,
            'transaction_id' => $request->transaction_id,
            'transDate' => $request->transDate,
        ]);


        if ($custSent) {
            return redirect()->back()->with('success', 'Money Sent Successfully');
        }else {
            return redirect()->back()->with('error', 'Money Sent Failed');
        }


        // return redirect()->back()->with('success', 'Money Received Successfully');
    }
}
