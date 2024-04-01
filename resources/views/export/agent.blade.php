<table class="table border-separate border border-slate-500 ">
    <thead>
        <tr>
            <th class="border border-slate-600 px-1">#</th>
            <th class="border border-slate-600 px-1">Date</th>
            <th class="border border-slate-600 px-3">Agent ID</th>
            <th class="border border-slate-600 px-3">Name</th>
            <th class="border border-slate-600 px-3">Number</th>
            <th class="border border-slate-600 px-3">Trans. type</th>
            <th class="border border-slate-600 px-3">Trans. ID</th>
            <th class="border border-slate-600 px-3">Amount (Taka)</th>
            <th class="border border-slate-600 px-3">Rate</th>

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
                <td class="border border-slate-600 px-3">{{ $info['tansDate'] }}</td>
                <td class="border border-slate-600 px-3">{{ $info['agent_id'] }}</td>
                <td class="border border-slate-600 px-3">{{ $info['user']['name'] }}</td>
                <td class="border border-slate-600 px-3">{{ $info['user']['number'] }}</td>
                <td class="border border-slate-600 px-3">{{ $info['transaction_type'] }}</td>
                <td class="border border-slate-600 px-3">{{ $info['transaction_id'] }}</td>
                <td class="border border-slate-600 px-3">
                    {{ $info['amount'] }}</td>
                <td class="border border-slate-600 px-3">
                    {{ $info['rate'] }} </td>
                @php
                    $totalMoney += $info['amount'];
                @endphp

            </tr>
        @endforeach


    </tbody>
    <tr>
        {{-- <td></td>
        <td></td>
        <td></td>
        <td></td> --}}

        <td colspan="7" class="border border-slate-600 px-3" style="text-align: right;">Grand
            total</td>
        <td
            class="border border-slate-600 px-3
         {{ $totalMoney < 0 ? 'bg-red-300' : '' }}">
            {{ $totalMoney }}</td>
    </tr>
</table>
