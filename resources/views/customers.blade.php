<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers Information') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 auto-cols-auto flex-row justify-items-start justify-between ">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-sm btn-dark bg-slate-800 mb-2" data-bs-toggle="modal"
                        data-bs-target="#user">
                        Add Customer
                    </button>

                    <table class="table table-striped table-secondary" id="dataTable">
                        <thead>
                            <tr>
                                <th>#</th>

                                <th>Name</th>
                                <th>Number</th>
                                <th>E-mail</th>
                                <th>Total Receive</th>
                                <th>Total Sends</th>
                                <th>Action</th>

                            </tr>

                        </thead>
                        <tbody>
                            @php
                                $totalSMoney = 0;
                                $totalRMoney = 0;
                                $sn = 0;
                            @endphp
                            @foreach ($combinedInfos as $info)
                                <tr>
                                    <form action="{{ route('customer.update') }}" method="POST">
                                        @csrf
                                        <td>{{ ++$sn }}</td>

                                        <td>

                                            <input type="text" class="form-control border-0"
                                                value="{{ $info['custName'] }}" name="name">
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
                                            {{ $info['total_received_money'] }} Taka</td>
                                        <td>
                                            {{ $info['total_sent_money'] }} Taka</td>

                                        <td>
                                            <input type="hidden" name="id" value="{{ $info['cust_id'] }}">
                                            <button type="submit"
                                                class="btn btn-sm btn-dark bg-slate-600 mb-2"
                                                onclick="return confirm('Are you sure you want to update?')"
                                                >Update</button>
                                        </td>
                                    </form>
                                    @php
                                        $totalRMoney += $info['total_received_money'];
                                    @endphp
                                    @php
                                        $totalSMoney += $info['total_sent_money'];
                                    @endphp

                                </tr>
                            @endforeach


                        </tbody>
                        <tr>
                            <td colspan="4" style="text-align: right;">Grand
                                total</td>
                            <td
                             {{ $totalRMoney < 0 ? 'bg-red-300' : '' }}">
                                {{ $totalRMoney }} Taka
                            </td>
                            <td
                             {{ $totalSMoney < 0 ? 'bg-red-300' : '' }}">
                                {{ $totalSMoney }} Taka
                            </td>
                        </tr>
                    </table>
                    {{-- {{$infos}} --}}
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            $(document).ready(function() {
                $('#userTable').DataTable({

                    buttons: [
                        'excel'
                    ]
                });
            });
        </script>
    </x-slot>

</x-app-layout>

<!-- Modal -->


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
                value="Customer" required autofocus autocomplete="role" />

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
