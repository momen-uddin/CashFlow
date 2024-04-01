<table class="table border-separate border border-slate-500 ">
    <thead>
        <tr>
            <th class="border border-slate-600 px-1">#</th>
            <th class="border border-slate-600 px-3">Agent ID</th>
            <th class="border border-slate-600 px-3">Name</th>
            <th class="border border-slate-600 px-3">Number</th>
            <th class="border border-slate-600 px-3">E-mail</th>
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
                <td class="border border-slate-600 px-3">{{ $info['agent_id'] }}</td>
                <td class="border border-slate-600 px-3">{{ $info['agent'] }}</td>
                <td class="border border-slate-600 px-3">{{ $info['number'] }}</td>
                <td class="border border-slate-600 px-3">{{ $info['email'] }}</td>
                <td class="border border-slate-600 px-3">
                    {{ $info['total_money'] }} Taka</td>
                @php
                    $totalMoney += $info['total_money'];
                @endphp

            </tr>
        @endforeach


    </tbody>
    <tr>
        {{-- <td></td>
        <td></td>
        <td></td>
        <td></td> --}}

        <td colspan="5" class="border border-slate-600 px-3" style="text-align: right;">Grand
            total</td>
        <td
            class="border border-slate-600 px-3
         {{ $totalMoney < 0 ? 'bg-red-300' : '' }}">
            {{ $totalMoney }} Taka</td>
    </tr>
</table>
