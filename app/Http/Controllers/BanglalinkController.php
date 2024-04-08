<?php

namespace App\Http\Controllers;

use App\Models\Banglalink;
use Illuminate\Http\Request;

class BanglalinkController extends Controller
{
    public function index()
    {
        $banglalink = Banglalink::all()
            ->sortByDesc('id');

        return view('telecom.banglalink', compact('banglalink'));
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

        $banglalink = new Banglalink();
        $banglalink->packName = $request->packName;
        $banglalink->title = $request->title;
        $banglalink->price = $request->price;
        $banglalink->validity = $request->validity;
        $banglalink->offerEndsIn = $request->offerEndsIn;
        $banglalink->save();

        if ($banglalink->save()) {

            $message = "Banglalink pack added successfully";
            return redirect()->back()->with('success', $message);
        } else {

            $message = "Banglalink pack added failed";
            return redirect()->back()->with('error', $message);
        }

    }

    public function delete(Request $request)
    {
        $banglalink = Banglalink::find($request->id);

        if ($banglalink) {
            $banglalink->delete();
            $message = "Banglalink pack deleted successfully";
            return redirect()->back()->with('success', $message);
        } else {
            $message = "Banglalink pack not found or deletion failed";
            return redirect()->back()->with('error', $message);
        }
    }
}
