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
        $infos = User::where('role', "Customer")->get();



        // Pass the combined information to the view
        return view('customers', compact('infos'));
        // return $dataTable->render('customers');

    }


}
