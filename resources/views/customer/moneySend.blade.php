<x-customer-layout>
    <x-slot name="header">
        <div class=" d-flex align-items-center ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-grow-1">
                {{ __('Money Send') }}
            </h2>

            <button type="button" class="btn btn-sm btn-dark bg-slate-600 mb-2" data-bs-toggle="modal"
                data-bs-target="#rm">
                Request for Money
            </button>
        </div>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 auto-cols-auto flex-row justify-items-start justify-between ">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table-auto border-separate border border-slate-500 " id="dataTable">
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

                                    <td class="border border-slate-600 px-3">
                                        {{ $info['amount'] }} Taka</td>


                                    @php
                                        $totalMoney += $info['amount'];
                                    @endphp

                                </tr>
                            @endforeach

                        </tbody>
                        <tr>
                            <td colspan="6" class="border border-slate-600 px-3" style="text-align: right;">
                                Total Send </td>
                            <td
                                class="border border-slate-600 px-3
                             {{ $totalMoney <= 0 ? 'bg-red-300' : '' }}">
                                {{ $totalMoney }} Taka</td>

                        </tr>
                    </table>
                    {{-- {{$infos}} --}}
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>

<!-- Modal -->

<div class="modal fade" id="rm" tabindex="-1" aria-labelledby="rmLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rmLabel">Request for Money</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{ route('requestMoney') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <x-input-label for="agent_id" value="Agent Name" />

                        <select
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 form-select"
                            aria-label="Default select example" name="agent_id">
                            <option selected>Agent Name</option>

                            @php
                                $data = DB::table('users')->where('role', 'Agent')->get();
                            @endphp

                            @foreach ($data as $name)
                                <option value="{{ $name->id }}">{{ $name->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <x-input-label for="amount" value="Amount" />
                        <x-text-input id="amount" class="block mt-1 w-full" type="text" name="amount"
                            :value="old('amount')" required autofocus />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="cust_number" value="Number" />
                        <x-text-input id="cust_number" class="block mt-1 w-full" type="text" name="cust_number"
                            :value="old('cust_number')" required autofocus />
                    </div>
                    <button type="submit" class="btn btn-dark bg-slate-600 float-end">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


