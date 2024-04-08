<?php

namespace App\Http\Controllers;

use App\Models\Grameen;
use Illuminate\Http\Request;

class GrameenController extends Controller
{
    public function index()
    {
        $grameen = Grameen::all()
            ->sortByDesc('id');

        return view('telecom.grameen', compact('grameen'));

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

        $grameen = new Grameen();
        $grameen->packName = $request->packName;
        $grameen->title = $request->title;
        $grameen->price = $request->price;
        $grameen->validity = $request->validity;
        $grameen->offerEndsIn = $request->offerEndsIn;
        $grameen->save();

        if ($grameen->save()) {

            $message = "Grameen pack added successfully";
            return redirect()->back()->with('success', $message);
        } else {

            $message = "Grameen pack added failed";
            return redirect()->back()->with('error', $message);
        }

    }

    public function delete(Request $request)
    {
        $grameen = Grameen::find($request->id);

        if ($grameen) {
            $grameen->delete();
            $message = "GrameenPhone pack deleted successfully";
            return redirect()->back()->with('success', $message);
        } else {
            $message = "GrameenPhone pack not found or deletion failed";
            return redirect()->back()->with('error', $message);
        }
    }
}
