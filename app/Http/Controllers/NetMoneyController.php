<?php

namespace App\Http\Controllers;


use App\Models\netMoney;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;


class NetMoneyController extends Controller
{
    public function index(Request $request)
    {

        // Pass the combined information to the view
        return view('agent');


    }
    public function agent(Request $request)
    {


        // Retrieve the data with the 'user' relationship
        $infos = NetMoney::with('user')
        ->get();
        // $infos = NetMoney::with('user:number')->get();
        // $infos = NetMoney::with(['user' => function ($query) {
        //     $query->select('id', 'name', 'number');
        // }])->get();


        // Group the entries by user_id
        $groupedInfos = $infos->groupBy('agent_id');

        // Iterate through each group and sum the money
        $combinedInfos = $groupedInfos->map(function ($group) {
            // Sum the 'money' column for each group
            $totalMoney = $group->sum('amount');

            // Get the first user object in the group (assuming they are all the same)
            $user = $group->first()->user;
            $number = $user->number;
            // dd($user);
            // Create a new object with combined information
            return [
                'agent_id' => $user->id,
                'agent' => $user->name,
                'number' => $number,
                'email' => $user->email,
                'total_money' => $totalMoney,
            ];
        });



        // Pass the combined information to the view

        // return DataTables::of($combinedInfos)->make(true);
        return view('agent', compact('combinedInfos'));

    }

    public function agentExport() {
        return Excel::download(new UsersExport(), 'users.xlsx');
    }

    public function getTransactions($id) {
        // Fetch transactions for the given agent ID
        $transactions = NetMoney::with('user')->where('agent_id', $id)->get();

        // Return the transactions as JSON
        return response()->json($transactions);

    }


    public function show($id)
    {
        // Retrieve the data with the 'user' relationship
        $infos = NetMoney::with('user')->where('agent_id', $id)->get();



        // Pass the combined information to the view
        return view('agent.moneyCollection', compact('infos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agent_id' => 'required',
            'amount' => 'required',
            'transaction_type' => 'required',
            'transaction_id' => 'required',
            'tansDate' => 'required',
        ]);

        NetMoney::create($request->all());

        return redirect()->route('agent')
            ->with('success', 'Transaction created successfully.');
    }
}
