<?php

namespace App\Exports;

use App\Models\User;
use App\Models\NetMoney;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

// class UsersExport implements FromCollection
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */

//     public function collection()
//     {
//         $infos = NetMoney::with('user')
//         ->get();
//         // $infos = NetMoney::with('user:number')->get();
//         // $infos = NetMoney::with(['user' => function ($query) {
//         //     $query->select('id', 'name', 'number');
//         // }])->get();


//         // Group the entries by user_id
//         $groupedInfos = $infos->groupBy('agent_id');

//         // Iterate through each group and sum the money
//         $combinedInfos = $groupedInfos->map(function ($group) {
//             // Sum the 'money' column for each group
//             $totalMoney = $group->sum('amount');

//             // Get the first user object in the group (assuming they are all the same)
//             $user = $group->first()->user;
//             $number = $user->number;
//             // dd($user);
//             // Create a new object with combined information
//             return [
//                 'agent_id' => $user->id,
//                 'agent' => $user->name,
//                 'number' => $number,
//                 'email' => $user->email,
//                 'total_money' => $totalMoney,
//             ];
//         });

//         return $combinedInfos;
//     }
// }
class UsersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {
        // $infos = NetMoney::with('user')
        // ->get();
        // // $infos = NetMoney::with('user:number')->get();
        // // $infos = NetMoney::with(['user' => function ($query) {
        // //     $query->select('id', 'name', 'number');
        // // }])->get();


        // // Group the entries by user_id
        // $groupedInfos = $infos->groupBy('agent_id');

        // // Iterate through each group and sum the money
        // $combinedInfos = $groupedInfos->map(function ($group) {
        //     // Sum the 'money' column for each group
        //     $totalMoney = $group->sum('amount');

        //     // Get the first user object in the group (assuming they are all the same)
        //     $user = $group->first()->user;
        //     $number = $user->number;
        //     // dd($user);
        //     // Create a new object with combined information
        //     return [
        //         'agent_id' => $user->id,
        //         'agent' => $user->name,
        //         'number' => $number,
        //         'email' => $user->email,
        //         'total_money' => $totalMoney,
        //     ];
        // });

        $combinedInfos= NetMoney::with('user')->get();

        // dd($combinedInfos);

        return view('export.agent', ['combinedInfos' => $combinedInfos]);
    }
}
