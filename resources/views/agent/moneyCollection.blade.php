<x-agent-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Money Information') }}
        </h2>
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
                                <th class="border border-slate-600 px-3">Agent ID</th>
                                <th class="border border-slate-600 px-3">Transection Type</th>
                                <th class="border border-slate-600 px-3">Transection ID</th>
                                <th class="border border-slate-600 px-3">Amount</th>
                                <th class="border border-slate-600 px-3">Rate</th>

                            </tr>

                        </thead>
                        <tbody>
                            @php
                                $totalMoney = 0;
                                $sn = 0;
                            @endphp
                            @foreach ($infos as $info)
                                <tr>
                                    <td class="border border-slate-600 px-3">{{ ++$sn }}</td>
                                    <td class="border border-slate-600 px-3">{{ custom_date($info['tansDate']) }}</td>
                                    <td class="border border-slate-600 px-3">{{ $info['agent_id'] }}</td>
                                    <td class="border border-slate-600 px-3">{{ $info['transaction_type'] }}</td>
                                    <td class="border border-slate-600 px-3">{{ $info['transaction_id'] }}</td>

                                    <td
                                        class="border border-slate-600 px-3">
                                        {{ $info['amount'] }} Taka</td>
                                    <td
                                        class="border border-slate-600 px-3">
                                        {{ $info['rate'] }}</td>
                                    @php
                                        $totalMoney += $info['amount'];
                                    @endphp

                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" class="border border-slate-600 px-3" style="text-align: right;">Grand
                                    total</td>
                                <td class="border border-slate-600 px-3
                                 {{ ($totalMoney <= 0) ? 'bg-red-300' : '' }}">{{ $totalMoney }} Taka</td>
                            </tr>

                        </tbody>
                    </table>
                    {{-- {{$infos}} --}}
                </div>
            </div>
        </div>
    </div>
</x-agent-layout>
