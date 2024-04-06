<table class="table-auto border-separate border border-slate-500 " id="dataTable">
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

                <td class="border border-slate-600 px-3">
                    {{ $info['amount'] }} Taka</td>

                @php
                    $totalMoney += $info['amount'];
                @endphp

            </tr>
        @endforeach

    </tbody>
    <tr>
        <td colspan="7" class="border border-slate-600 px-3" style="text-align: right;">
            Total Sent </td>
        <td
            class="border border-slate-600 px-3
         {{ $totalMoney <= 0 ? 'bg-red-300' : '' }}">
            {{ $totalMoney }} Taka</td>
    </tr>
</table>
