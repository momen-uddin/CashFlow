<?php

namespace App\Exports;

use App\Models\CustReceive;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MoneySentExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        $combinedInfos = CustReceive::with(['user', 'agent'])
        ->where('status', 'Approved')
        ->get()
        ->map(function ($item) {
            return [
                'cust_name' => $item->user->name,
                'cust_number' => $item->cust_number,
                'agent_name' => $item->agent->name,
                'trans_type' => $item->transaction_type,
                'trans_id' => $item->transaction_id,
                'amount' => $item->amount,
                'transDate' => $item->transDate,
                // Add other fields from CustReceive model if needed
            ];
        });


        // dd($combinedInfos);

        return view('export.moneySent', ['combinedInfos' => $combinedInfos]);
    }
}
