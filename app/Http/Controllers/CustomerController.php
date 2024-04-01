<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
