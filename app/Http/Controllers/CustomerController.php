<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\CustSents;
use App\Models\CustReceive;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Exports\MoneySentExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index()
    {


        $CustReceive = CustReceive::all()->where('cust_id', auth()->user()->id)->sum('amount');
        $CustSent = CustSents::all()->where('cust_id', auth()->user()->id)->sum('amount');

        $monthlyData = [];

        // Collect data for each month
        for ($month = 1; $month <= 12; $month++) {
            $monthlyData[$month] = [

                'CustSent' => CustSents::whereMonth('transDate', $month)->where('cust_id', auth()->user()->id)->sum('amount'),
                'CustReceive' => CustReceive::whereMonth('transDate', $month)->where('cust_id', auth()->user()->id)->sum('amount'),
            ];
        }

        // Prepare data for the line chart
        $labels = [];

        $custSentData = [];
        $custReceiveData = [];


        foreach ($monthlyData as $month => $data) {
            $labels[] = DateTime::createFromFormat('!m', $month)->format('F'); // Convert month number to month name

            $custSentData[] = $data['CustSent'];
            $custReceiveData[] = $data['CustReceive'];
        }



        $chartData = [
            'labels' => $labels,
            'datasets' => [

                [
                    'label' => 'Send',
                    'data' => $custSentData,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Received',
                    'data' => $custReceiveData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];

        $transactions = DB::table('cust_receives')
            ->select('cust_receives.id', 'cust_receives.cust_id', 'users.name as cust_name', 'cust_receives.amount', 'cust_receives.transDate')
            ->where('cust_id', auth()->user()->id)
            ->join('users', 'cust_receives.cust_id', '=', 'users.id')
            // ->where('cust_receives.transDate', '>=', now()->startOfWeek())
            // ->where('cust_receives.transDate', '<=', now()->endOfWeek())
            ->orderByDesc('cust_receives.transDate')
            ->limit(7)
            ->get();



        // dd($transactions);

        return view('customer.dashboard', compact( 'CustSent', 'CustReceive', 'chartData', 'transactions'));
    }

    public function showAll()
    {
        // Retrieve the data with the 'user' relationship
        $infos = User::with(['custReceive', 'custSents'])->where('role', "Customer")->get();


        $groupedInfos = $infos->groupBy('id');
        // dd($groupedInfos);
        // Iterate through each group and sum the sents money and received money
        $combinedInfos = $groupedInfos->map(function ($group) {


            // Get the first user object in the group (assuming they are all the same)
            $user = $group->first();

            // Check if $user is not null before accessing its properties
            if ($user) {
                // Sum the 'amount' column for CustReceive
                $totalSentMoney = $user->custSents->sum('amount');
                // Sum the 'amount' column for CustSents
                $totalReceivedMoney = $user->custReceive->sum('amount');

                $number = $user->number;
                // Create a new object with combined information
                return [
                    'cust_id' => $user->id,
                    'custName' => $user->name,
                    'number' => $number,
                    'email' => $user->email,
                    'total_sent_money' => $totalSentMoney,
                    'total_received_money' => $totalReceivedMoney,
                ];
            } else {
                // Handle the case where $user is null (optional)

            }
        });

        // Pass the combined information to the view
        return view('customers', compact('combinedInfos'));
        // return $dataTable->render('customers');

    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'name' => 'string',
            'number' => ['string', 'max:50', 'unique:' . User::class . ',number,' . $request->id],
            'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $request->id],

        ]);


        $user = $request->id;
        $user = User::find($user);

        $user->name = $request->name;
        $user->number = $request->number;
        $user->email = $request->email;

        if ($user->save()) {
            return redirect()->back()->with('success', 'User updated successfully.');
        } else {
            return redirect()->back()->with('error', 'User not updated.');

        }

    }


}
