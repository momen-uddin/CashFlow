<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\netMoney;
use App\Models\CustSents;
use App\Models\CustReceive;
use Illuminate\Http\Request;

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
                    'label' => 'Customer Sent',
                    'data' => $custSentData,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Customer Received',
                    'data' => $custReceiveData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];



        return view('dashboard', compact('Agent', 'CustSent', 'CustReceive', 'chartData'));
    }
}
