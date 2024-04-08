<?php

namespace App\Http\Controllers;

use App\Models\Airtel;
use Illuminate\Http\Request;

class AirtelController extends Controller
{
    public function index()
    {

        $airtel = Airtel::all()
            ->sortByDesc('id');

        return view('telecom.airtel', compact('airtel'));
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

        date_default_timezone_set('Asia/Dhaka');

        $airtel = new Airtel();
        $airtel->packName = $request->packName;
        $airtel->title = $request->title;
        $airtel->price = $request->price;
        $airtel->validity = $request->validity;
        $airtel->offerEndsIn = $request->offerEndsIn;
        $airtel->save();
        if ($airtel->save()) {

            $message = "Airtel pack added successfully";
            return redirect()->back()->with('success', $message);

        } else {

            $message = "Airtel pack added failed";
            return redirect()->back()->with('error', $message);
        }
    }
    public function delete(Request $request)
    {
        // $request->validate([
        //     'id' => 'required'
        // ]);

        $airtel = Airtel::find($request->id);

        if ($airtel) {
            $airtel->delete();
            $message = "Airtel pack deleted successfully";
            return redirect()->back()->with('success', $message);
        } else {
            $message = "Airtel pack not found or deletion failed";
            return redirect()->back()->with('error', $message);
        }
    }


}
