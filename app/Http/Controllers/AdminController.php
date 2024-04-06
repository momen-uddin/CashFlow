<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\netMoney;
use App\Models\CustSents;
use App\Models\CustReceive;
use Illuminate\Http\Request;
use App\Exports\MoneySentExport;
use App\Exports\MoneyReciveExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\AdminNotification;

class AdminController extends Controller
{
    public function index()
    {

        $Agent = netMoney::all()->sum('amount');
        $CustSent = CustReceive::all()->sum('amount');
        $CustReceive = CustSents::all()->sum('amount');

        $monthlyData = [];

        // Collect data for each month
        for ($month = 1; $month <= 12; $month++) {
            $monthlyData[$month] = [
                'Agent' => netMoney::whereMonth('tansDate', $month)->sum('amount'),
                'CustSent' => CustReceive::whereMonth('transDate', $month)->sum('amount'),
                'CustReceive' => CustSents::whereMonth('transDate', $month)->sum('amount'),
            ];
        }

        // Prepare data for the line chart
        $labels = [];
        $agentData = [];
        $custSentData = [];
        $custReceiveData = [];


        foreach ($monthlyData as $month => $data) {
            $labels[] = DateTime::createFromFormat('!m', $month)->format('F'); // Convert month number to month name
            $agentData[] = $data['Agent'];
            $custSentData[] = $data['CustSent'];
            $custReceiveData[] = $data['CustReceive'];
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
                    'label' => 'Sent to Customer',
                    'data' => $custSentData,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Received from Customer',
                    'data' => $custReceiveData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
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

        return view('dashboard', compact('Agent', 'CustSent', 'CustReceive', 'chartData', 'transactions'));
    }

    public function moneySent_Export() {

        //sent email to the admin

        // $email = "stareye714@gmail.com";
        // $msg = "Money Sent Transaction Exported Successfully";
        // Notification::route('mail', $email)->notify(new AdminNotification($msg));


        return Excel::download(new MoneySentExport(), 'MoneySent_transactions.xlsx');

        // return Excel::download(new UsersExport(), 'Agent_transactions.xlsx');
    }
    public function moneyRecive_Export() {

        return Excel::download(new MoneyReciveExport(), 'MoneyRecive_transactions.xlsx');

        // return Excel::download(new UsersExport(), 'Agent_transactions.xlsx');
    }
}
