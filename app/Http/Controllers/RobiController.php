<?php

namespace App\Http\Controllers;

use App\Models\Robi;
use Illuminate\Http\Request;

class RobiController extends Controller
{
    public function index()
    {
        return view('telecom.robi');
    }
    public function store(Request $request)
    {

        $request->validate([
            'packName' => 'required',
            'title' => 'required',
            'price' => 'required|numeric',
            'validity' => 'required|numeric',
            'offerEndsIn' => 'numeric'
        ]);

        $robi = new Robi();
        $robi->packName = $request->packName;
        $robi->title = $request->title;
        $robi->price = $request->price;
        $robi->validity = $request->validity;
        $robi->offerEndsIn = $request->offerEndsIn;
        $robi->save();

        if ($robi->save()) {

            $message = "Robi pack added successfully";
            return redirect()->back()->with('success', $message);
        } else {

            $message = "Robi pack added failed";
            return redirect()->back()->with('error', $message);
        }

    }
}
