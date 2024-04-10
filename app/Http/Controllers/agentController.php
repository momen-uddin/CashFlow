<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\netMoney;
use App\Models\CustSents;
use Illuminate\View\View;
use App\Models\CustReceive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class agentController extends Controller
{
    public function index()
    {

        $Agent = netMoney::all()->where('agent_id', auth()->user()->id)->sum('amount');
        $CustSent = CustReceive::all()->where('agent_id', auth()->user()->id)->sum('amount');


        $monthlyData = [];

        // Collect data for each month
        for ($month = 1; $month <= 12; $month++) {
            $monthlyData[$month] = [
                'Agent' => netMoney::whereMonth('tansDate', $month)->where('agent_id', auth()->user()->id)->sum('amount'),
                'CustSent' => CustReceive::whereMonth('transDate', $month)->where('agent_id', auth()->user()->id)->sum('amount'),

            ];
        }

        // Prepare data for the line chart
        $labels = [];
        $agentData = [];
        $custSentData = [];



        foreach ($monthlyData as $month => $data) {
            $labels[] = DateTime::createFromFormat('!m', $month)->format('F'); // Convert month number to month name
            $agentData[] = $data['Agent'];
            $custSentData[] = $data['CustSent'];

        }



        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Agent',
                    'data' => $agentData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Send to Customer',
                    'data' => $custSentData,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],

            ],
        ];

        $transactions = DB::table('cust_receives')
            ->select('cust_receives.id', 'cust_receives.cust_id', 'users.name as cust_name', 'cust_receives.amount', 'cust_receives.transDate')
            ->join('users', 'cust_receives.cust_id', '=', 'users.id')
            // ->where('cust_receives.transDate', '>=', now()->startOfWeek())
            // ->where('cust_receives.transDate', '<=', now()->endOfWeek())
            ->orderByDesc('cust_receives.transDate')
            ->limit(7)
            ->get();



        // dd($transactions);

        return view('agent.dashboard', compact('Agent', 'CustSent', 'chartData', 'transactions'));
    }


    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'name' => 'string',
            'number' => ['string', 'max:50', 'unique:'.User::class.',number,'.$request->id],
            'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$request->id],

        ]);


        $user = $request->id;
        $user = User::find($user);

        $user->name = $request->name;
        $user->number = $request->number;
        $user->email = $request->email;

        if ($user->save()) {
            return redirect()->back()->with('success', 'User updated successfully.');
        }else {
            return redirect()->back()->with('error', 'User not updated.');

        }

    }

}
