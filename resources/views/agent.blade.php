<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agent Information (Money given to agent)') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 auto-cols-auto flex-row justify-items-start justify-between ">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-sm btn-dark bg-slate-800 mb-2" data-bs-toggle="modal"
                        data-bs-target="#user">
                        Add Agent
                    </button>

                    <button type="button" class="btn btn-sm btn-dark bg-slate-800 mb-2" data-bs-toggle="modal"
                        data-bs-target="#agent">
                        Add Money to Agent
                    </button>

                    <a href="{{ route('agent.export') }}" class="btn btn-sm btn-dark mb-2 float-end"><i
                            class="fa-regular fa-file-excel"></i>&nbspExport</a>


                    <table class="table table-striped table-secondary" id="dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Agent ID</th>
                                <th>Name</th>
                                <th>Number</th>
                                <th>E-mail</th>
                                <th>Amount</th>
                                <th>Transections</th>
                                <th>Action</th>

                            </tr>

                        </thead>
                        <tbody>

                            @php
                                $totalMoney = 0;
                                $sn = 0;
                            @endphp
                            @foreach ($combinedInfos as $info)
                                <tr>
                                    <form action="{{ route('agent.update') }}" method="POST">
                                        @csrf
                                        <td>{{ ++$sn }}</td>
                                        <td>{{ $info['agent_id'] }}</td>
                                        <td>
                                            <input type="text" class="form-control border-0"
                                                value="{{ $info['agent'] }}" name="name">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control max-w-40 border-0"
                                                value="{{ $info['number'] }}" name="number">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control border-0"
                                                value="{{ $info['email'] }}" name="email">
                                        </td>
                                        <td>
                                            {{ $info['total_money'] }} Taka
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-dark bg-slate-800 mb-2"
                                                data-bs-toggle="modal" data-bs-target="#agentTrans" id="trans">
                                                Transections
                                            </button>
                                        </td>
                                        <td>
                                            <input type="hidden" name="id" value="{{ $info['agent_id'] }}">
                                            <button type="submit"
                                                class="btn btn-sm btn-dark bg-slate-600 mb-2"
                                                onclick="return confirm('Are you sure you want to update?')"
                                                >Update</button>
                                        </td>
                                    </form>
                                </tr>
                                @php
                                    $totalMoney += $info['total_money'];
                                @endphp
                            @endforeach



                        </tbody>
                        <tr>
                            {{-- <td></td>
                            <td></td>
                            <td></td>
                            <td></td> --}}

                            <td colspan="5" style="text-align: right;">Grand
                                total</td>
                            <td colspan="3"

                             {{ $totalMoney < 0 ? 'bg-red-300' : '' }}">
                                {{ $totalMoney }} Taka</td>
                        </tr>
                    </table>

                    {{-- {{$infos}} --}}
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade modal-lg" id="agentTrans" tabindex="-1" aria-labelledby="agentTransLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agentTransLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table-auto border-separate border border-slate-500 ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Number</th>
                                <th>Transection Type</th>
                                <th>Transection ID</th>
                                <th>Amount</th>
                                <th>Rate</th>

                            </tr>

                        </thead>
                        <tbody id="tableData">

                        </tbody>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm bg-dark btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <x-slot name="script">
        <script type="text/javascript">
            $(document).ready(function() {
                $('#agentTable').DataTable({});

            });
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#trans').click(function() {
                    var agentId = $(this).closest('tr').find('td:eq(1)')
                        .text(); // Get the agent ID from the table row
                    $.ajax({
                        url: 'agent/' + agentId, // Include '/transactions' in the URL
                        type: 'GET',
                        success: function(response) {
                            // Update modal content with transactions
                            var modalBody = $('#agentTrans .modal-body #tableData');
                            modalBody.empty();

                            // Iterate over each transaction in the response and append to the table
                            $.each(response, function(index, transaction) {
                                modalBody.append('<tr>' +
                                    '<td>' + (
                                        index + 1) + '</td>' +
                                    '<td>' +
                                    transaction.tansDate + '</td>' +
                                    '<td>' +
                                    transaction.user.number + '</td>' +
                                    '<td>' +
                                    transaction.transaction_type + '</td>' +
                                    '<td>' +
                                    transaction.transaction_id + '</td>' +
                                    '<td>' +
                                    transaction.amount + '</td>' +
                                    '<td>' +
                                    transaction.rate + '</td>' +
                                    '</tr>');
                                $('#agentTransLabel').text(transaction.user.name);
                            });

                            console.log(response);

                            // Show the modal
                            $('#agentTrans').modal('show');
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            });
        </script>



    </x-slot>



    <!-- Design by Md. Momen Uddin -->

</x-app-layout>
<!-- Design by Md. Momen Uddin -->
<!-- Modal -->

<x-i_modal title="Add Agent Money" id="agent">
    <form action="{{ route('addAgentMoney') }}" method="POST">
        @csrf
        <x-input-label for="agent_name" value="Agent name" />

        <select class="form-select" aria-label="Default select example" name="agent_id">
            <option selected>Agent Name</option>

            @php
                $data = DB::table('users')->where('role', 'Agent')->get();
            @endphp

            @foreach ($data as $name)
                <option value="{{ $name->id }}">{{ $name->name }}</option>
            @endforeach
        </select>

        <x-input-label for="amount" value="Amount" />
        <x-text-input id="amount" class="block mt-1 w-full" type="text" name="amount" :value="old('amount')"
            required autofocus />

        <x-input-label for="transaction_type" value="Transaction Type" />
        <x-text-input id="transaction_type" class="block mt-1 w-full" type="text" name="transaction_type"
            :value="old('transaction_type')" required autofocus />

        <x-input-label for="transaction_id" value="Transaction ID" />
        <x-text-input id="transaction_id" class="block mt-1 w-full" type="text" name="transaction_id"
            :value="old('transaction_id')" required autofocus />

        <x-input-label for="rate" value="Rate" />
        <x-text-input id="rate" class="block mt-1 w-full" type="text" name="rate" :value="old('rate')"
            required autofocus />

        <x-input-label for="tansDate" value="Date" />
        @php
            date_default_timezone_set('Asia/Dhaka');
            $date = date('Y-m-d H:i:s');
        @endphp
        <x-text-input id="tansDate" class="block mt-1 w-full" type="text" name="tansDate" :value="$date"
            required autofocus />



        <input type="submit" value="Insert" class="btn btn-sm btn-dark bg-slate-600 mt-1 mb-1 float-end">
    </form>
</x-i_modal>

<x-i_modal title="Add User" id="user">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            {{-- <select class="form-select" aria-label="Default select example" name="role">
                <option value="Master Admin">Master Admin</option>
                <option value="Admin">Admin</option>
                <option value="Agent" selected>Agent</option>
            </select> --}}
            <x-text-input id="role" class="block mt-1 w-full" readonly type="text" name="role"
                value="Agent" required autofocus autocomplete="role" />

        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>


        <!-- Numberr -->
        <div class="mt-4">
            <x-input-label for="number" :value="__('Number')" />
            <x-text-input id="number" class="block mt-1 w-full" type="text" name="number" :value="old('number')"
                required autocomplete="number" />
            <x-input-error :messages="$errors->get('number')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-i_modal>
<!-- Design by Md. Momen Uddin -->
