<?php

namespace App\Http\Controllers;

use App\Models\Robi;
use App\Models\Airtel;
use App\Models\Grameen;
use App\Models\Banglalink;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $robiPacks = [
            ['type' => 'Internet', 'data' => Robi::where('packName', 'Internet')->get()->sortByDesc('id')],
            ['type' => 'Minutes', 'data' => Robi::where('packName', 'Minutes')->get()->sortByDesc('id')],
            ['type' => 'Call Rate', 'data' => Robi::where('packName', 'Call Rate')->get()->sortByDesc('id')],
            ['type' => 'Combo', 'data' => Robi::where('packName', 'Combo')->get()->sortByDesc('id')],
        ];

        $banglalinkPacks = [
            ['type' => 'Internet', 'data' => Banglalink::where('packName', 'Internet')->get()->sortByDesc('id')],
            ['type' => 'Minutes', 'data' => Banglalink::where('packName', 'Minutes')->get()->sortByDesc('id')],
            ['type' => 'Call Rate', 'data' => Banglalink::where('packName', 'Call Rate')->get()->sortByDesc('id')],
            ['type' => 'Combo', 'data' => Banglalink::where('packName', 'Combo')->get()->sortByDesc('id')],
        ];

        $airtelPacks = [
            ['type' => 'Internet', 'data' => Airtel::where('packName', 'Internet')->get()->sortByDesc('id')],
            ['type' => 'Minutes', 'data' => Airtel::where('packName', 'Minutes')->get()->sortByDesc('id')],
            ['type' => 'Call Rate', 'data' => Airtel::where('packName', 'Call Rate')->get()->sortByDesc('id')],
            ['type' => 'Combo', 'data' => Airtel::where('packName', 'Combo')->get()->sortByDesc('id')],
        ];

        $grameenPacks = [
            ['type' => 'Internet', 'data' => Grameen::where('packName', 'Internet')->get()->sortByDesc('id')],
            ['type' => 'Minutes', 'data' => Grameen::where('packName', 'Minutes')->get()->sortByDesc('id')],
            ['type' => 'Call Rate', 'data' => Grameen::where('packName', 'Call Rate')->get()->sortByDesc('id')],
            ['type' => 'Combo', 'data' => Grameen::where('packName', 'Combo')->get()->sortByDesc('id')],
        ];

        return view('welcome', compact('robiPacks', 'banglalinkPacks', 'airtelPacks', 'grameenPacks'));
    }

}
