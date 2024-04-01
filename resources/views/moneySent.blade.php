<x-app-layout>
    <x-slot name="header">

        <div class=" d-flex align-items-center ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-grow-1">
                {{ __('Money Sent to Customer') }}
            </h2>
            <button type="button" class="btn btn-sm btn-dark bg-slate-600 mb-2" data-bs-toggle="modal"
                data-bs-target="#pendingMoney">
                Add Money Recieved
            </button>
        </div>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 auto-cols-auto flex-row justify-items-start justify-between ">


                    <table class="table-auto border-separate border border-slate-500 ">
                        <thead>
                            <tr>
                                <th class="border border-slate-600 px-3">#</th>
                                <th class="border border-slate-600 px-3">Date</th>
                                <th class="border border-slate-600 px-3">Customer Name</th>
                                <th class="border border-slate-600 px-3">Customer Number</th>
                                <th class="border border-slate-600 px-3">Agent Name</th>
                                <th class="border border-slate-600 px-3">Transection Type</th>
                                <th class="border border-slate-600 px-3">Transection ID</th>
                                <th class="border border-slate-600 px-3">Amount</th>


                            </tr>

                        </thead>
                        <tbody>
                            @php
                                $totalMoney = 0;
                                $sn = 0;
                            @endphp
                            @foreach ($combinedInfos as $info)
                                <tr>
                                    <td class="border border-slate-600 px-3">{{ ++$sn }}</td>
                                    <td class="border border-slate-600 px-3">{{ custom_date($info['transDate']) }}</td>
                                    <td class="border border-slate-600 px-3">{{ $info['cust_name'] }}</td>
                                    <td class="border border-slate-600 px-3">{{ $info['cust_number'] }}</td>
                                    <td class="border border-slate-600 px-3">{{ $info['agent_name'] }}</td>

                                    <td class="border border-slate-600 px-3">{{ $info['trans_type'] }}</td>
                                    <td class="border border-slate-600 px-3">{{ $info['trans_id'] }}</td>

                                    <td
                                        class="border border-slate-600 px-3">
                                        {{ $info['amount'] }} Taka</td>

                                    @php
                                        $totalMoney += $info['amount'];
                                    @endphp

                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="7" class="border border-slate-600 px-3" style="text-align: right;">
                                    Total Sent (Customer)</td>
                                <td class="border border-slate-600 px-3
                                 {{ ($totalMoney <= 0) ? 'bg-red-300' : '' }}">{{ $totalMoney }} Taka</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="border border-slate-600 px-3" style="text-align: right;">Total Sent (Agent)
                                    </td>
                                <td class="border border-slate-600 px-3
                                 {{ ($have <= 0) ? 'bg-red-300' : '' }}">{{ $have }} Taka</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="border border-slate-600 px-3" style="text-align: right;">Net Amount
                                    </td>
                                <td class="border border-slate-600 px-3
                                 {{ (($have - $totalMoney) <= 0) ? 'bg-red-300' : '' }}">{{ $have - $totalMoney }} Taka</td>
                            </tr>

                        </tbody>
                    </table>
                    {{-- {{$pendingMoneys}} --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Modal -->
<!-- Design by Md. Momen Uddin -->
