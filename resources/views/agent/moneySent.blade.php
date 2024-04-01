<x-agent-layout>
    <x-slot name="header">

        <div class=" d-flex align-items-center ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-grow-1">
                {{ __('Money Sent to Customer') }}
            </h2>
            <button type="button" class="btn btn-sm btn-dark bg-slate-600 mb-2" data-bs-toggle="modal"
                data-bs-target="#pendingMoney">
                Pending Request
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
                                <td colspan="6" class="border border-slate-600 px-3" style="text-align: right;">
                                    Total Sent</td>
                                <td class="border border-slate-600 px-3
                                 {{ ($totalMoney <= 0) ? 'bg-red-300' : '' }}">{{ $totalMoney }} Taka</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="border border-slate-600 px-3" style="text-align: right;">Total Have
                                    </td>
                                <td class="border border-slate-600 px-3
                                 {{ ($have <= 0) ? 'bg-red-300' : '' }}">{{ $have }} Taka</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="border border-slate-600 px-3" style="text-align: right;">Net Amount
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
</x-agent-layout>

<!-- Modal -->

<div class="modal fade modal-xl" id="pendingMoney" tabindex="-1" aria-labelledby="pendingMoneyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pendingMoneyLabel">Pending Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table-auto border-separate border border-slate-500 ">
                    <thead>
                        <tr>
                            <th class="border border-slate-600 px-3">#</th>
                            <th class="border border-slate-600 px-3">Date</th>
                            <th class="border border-slate-600 px-3">Customer Name</th>
                            <th class="border border-slate-600 px-3">Customer Number</th>
                            <th class="border border-slate-600 px-3">Transection Type</th>
                            <th class="border border-slate-600 px-3">Transection ID</th>
                            <th class="border border-slate-600 px-3">Amount</th>
                            <th class="border border-slate-600 px-3">Action</th>
                        </tr>

                    </thead>
                    <tbody>
                        @php
                            $sn = 0;
                        @endphp
                        @foreach ($pendingMoneys as $pendingMoney)
                            <tr>
                                <form action="{{ route('agent.approveMoneySent') }}" method="POST">
                                    @csrf

                                <td class="border border-slate-600 px-3">{{ ++$sn }}</td>
                                <td class="border border-slate-600 px-3">{{ custom_date($pendingMoney['transDate']) }}</td>
                                <td class="border border-slate-600 px-3">{{ $pendingMoney['cust_name'] }}</td>
                                <td class="border border-slate-600 px-3">{{ $pendingMoney['cust_number'] }}</td>
                                <td class="border border-slate-600 px-3">
                                    {{-- <input type="text" class="border-0 p-0 w-100" name="trans_type" value="{{ $pendingMoney['trans_type'] }}"> --}}
                                    <select name="trans_type" id="trans_type" class="border-0 p-0 w-100">
                                        <option value="bKash">bKash</option>
                                        <option value="Rocket">Rocket</option>
                                        <option value="Nagad">Nagad</option>
                                    </select>
                                </td>
                                <td class="border border-slate-600 px-3">
                                    <input type="text" class="border-0 p-0 w-100" name="trans_id" value="{{ $pendingMoney['trans_id'] }}">
                                </td>

                                <td class="border border-slate-600 px-3">

                                    <input type="text" class="border-0 p-0 w-100" name="amount" value="{{ $pendingMoney['amount'] }}">

                                </td>
                                <td class="border border-slate-600 px-3">

                                        <input type="hidden" name="id" value="{{ $pendingMoney['id'] }}">
                                        <button type="submit" class="btn btn-sm btn-dark bg-slate-600 mb-2">Sent</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


