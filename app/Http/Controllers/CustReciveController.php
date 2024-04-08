<?php

namespace App\Http\Controllers;

use App\Models\CustReceive;
use App\Models\CustSents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\netMoney;

class CustReciveController extends Controller
{
    public function index()
    {
        // Retrieve the data with the 'user' relationship

        $combinedInfos = CustReceive::with(['user', 'agent'])
        ->where('status', 'Approved')
        ->orderByDesc('id')
        ->get()->map(function ($item) {
            return [
                'cust_name' => $item->user->name,
                'cust_number' => $item->cust_number,
                'agent_name' => $item->agent->name,
                'trans_type' => $item->transaction_type,
                'trans_id' => $item->transaction_id,
                'amount' => $item->amount,

                'transDate' => $item->transDate,
                // Add other fields from CustReceive model if needed
            ];
        });




        // Pass the combined information to the view
        return view('moneySent', compact('combinedInfos'));

    }

    public function agentShow()
    {
        // Retrieve the data with the 'user' relationship

        $combinedInfos = CustReceive::with('user')->where('agent_id', auth()->user()->id)
        ->where('status', 'Approved')
        ->orderByDesc('id')
        ->get()->map(function ($item) {
            return [
                'cust_name' => $item->user->name,
                'cust_number' => $item->cust_number,
                'trans_type' => $item->transaction_type,
                'trans_id' => $item->transaction_id,
                'amount' => $item->amount,
                'transDate' => $item->transDate,
                // Add other fields from CustReceive model if needed
            ];
        });

        $have = netMoney::where('agent_id', auth()->user()->id)->sum('amount');

        $pendingMoneys = CustReceive::with('user')->where('status', 'Pending')
        ->where('agent_id', auth()->user()->id)
        ->orderByDesc('id')
        ->get()->map(function ($item) {
            return [
                'id'=> $item->id,
                'cust_name' => $item->user->name,
                'cust_number' => $item->cust_number,
                'trans_type' => $item->transaction_type,
                'trans_id' => $item->transaction_id,
                'amount' => $item->amount,
                'transDate' => $item->transDate,
                // Add other fields from CustReceive model if needed
            ];
        });



        // Pass the combined information to the view
        return view('agent.moneySent', compact('combinedInfos', 'have', 'pendingMoneys'));

    }
    public function custShow()
    {
        // Retrieve the data with the 'user' relationship

        $combinedInfos = CustReceive::with(['user', 'agent'])
        ->where('cust_id', auth()->user()->id)
        ->where('status', 'Approved')
        ->orderByDesc('id')
        ->get()
        ->map(function ($item) {
            return [
                'cust_name' => $item->user->name,
                'cust_number' => $item->cust_number,
                'agent_name' => $item->agent->name,
                'trans_type' => $item->transaction_type,
                'trans_id' => $item->transaction_id,
                'amount' => $item->amount,
                'transDate' => $item->transDate,
                // Add other fields from CustReceive model if needed
            ];
        });

        $sent = CustSents::where('cust_id', auth()->user()->id)->sum('amount');

        // last order show in top
        $pendingMoneys = CustReceive::with('user')->where('status', 'Pending')
        ->where('cust_id', auth()->user()->id)
        ->orderByDesc('id')
        ->get()->map(function ($item) {
            return [
                'id'=> $item->id,
                'cust_name' => $item->user->name,
                'cust_number' => $item->cust_number,
                'trans_type' => $item->transaction_type,
                'trans_id' => $item->transaction_id,
                'amount' => $item->amount,
                'transDate' => $item->transDate,
                // Add other fields from CustReceive model if needed
            ];
        });



        // Pass the combined information to the view
        return view('customer.moneyCollection', compact('combinedInfos', 'sent', 'pendingMoneys'));

    }

    public function requestMoney(Request $request)
    {
        $request->validate([
            'agent_id' => 'required',
            'cust_number' => 'required',
            'amount' => 'required',
        ]);

        // timezone
        date_default_timezone_set('Asia/Dhaka');


        $cust_id = auth()->user()->id;
        // Create a new CustReceive object
        $custReceive = new CustReceive();
        $custReceive->cust_id = $cust_id;
        $custReceive->agent_id = $request->agent_id;
        $custReceive->cust_number = $request->cust_number;
        $custReceive->amount = $request->amount;

        $custReceive->transDate = date('Y-m-d H:i:s');
        $custReceive->save();




        // Redirect to the previous page
        return redirect()->back()->with('success', 'Money request sent successfully');
    }

    public function updateMoney(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'cust_number' => 'required',
            'amount' => 'required',
        ]);

        // timezone
        date_default_timezone_set('Asia/Dhaka');

        // Create a new CustSents object
        $custSents = CustReceive::find($request->id);
        $custSents->cust_number = $request->cust_number;
        $custSents->amount = $request->amount;

        $custSents->save();

        // Redirect to the previous page
        return redirect()->back()->with('success', 'Request update successfully');
    }

    public function approveMoneySent(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $custReceive = CustReceive::find($request->id);
        $custReceive->transaction_type = $request->trans_type;
        $custReceive->transaction_id  = $request->trans_id;
        $custReceive->amount  = $request->amount;
        $custReceive->status = 'Approved';
        $custReceive->save();



        return redirect()->back()->with('success', 'Money sent successfully');

    }

}
