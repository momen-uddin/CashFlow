<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Exports\MoneySentExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index()
    {

        return view('customer.dashboard');

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
