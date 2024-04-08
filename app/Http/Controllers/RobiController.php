<?php

namespace App\Http\Controllers;

use App\Models\Robi;
use Illuminate\Http\Request;

class RobiController extends Controller
{
    public function index()
    {
        $robi = Robi::all()
            ->sortByDesc('id');

        return view('telecom.robi', compact('robi'));
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

    public function delete(Request $request) {
        $robi = Robi::find($request->id);

        if ($robi) {
            $robi->delete();
            $message = "Robi pack deleted successfully";
            return redirect()->back()->with('success', $message);
        } else {
            $message = "Robi pack not found or deletion failed";
            return redirect()->back()->with('error', $message);
        }
    }
}
