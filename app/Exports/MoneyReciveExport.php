<?php

namespace App\Exports;

use App\Models\CustSents;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MoneyReciveExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        $combinedInfos = CustSents::with(['user'])
        ->get()->map(function ($item) {
            return [
                'cust_name' => $item->user->name,
                'cust_number' => $item->user->number,
                'trans_type' => $item->transaction_type,
                'trans_id' => $item->transaction_id,
                'amount' => $item->amount,

                'transDate' => $item->transDate,
                'rate' => $item->rate,
                // Add other fields from CustReceive model if needed
            ];
        });

        $combinedInfos= CustSents::with('user')->get();
        return view('export.moneyRecive', ['combinedInfos' => $combinedInfos]);

    }
}
