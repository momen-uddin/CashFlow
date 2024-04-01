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
                    <button type="button" class="btn btn-sm bg-secondary bg-slate-600 mb-2" data-bs-toggle="modal" data-bs-target="#user">
                        Add Customer
                    </button>


                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table-auto border-separate border border-slate-500 " id="userTable">
                        <thead>
                            <tr>
                                <th class="border border-slate-600 px-3">#</th>

                                <th class="border border-slate-600 px-3">Name</th>
                                <th class="border border-slate-600 px-3">Number</th>
                                <th class="border border-slate-600 px-3">E-mail</th>
                                {{-- <th class="border border-slate-600 px-3">Amount</th> --}}

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

                                    <td class="border border-slate-600 px-3">{{ $info['name'] }}</td>
                                    <td class="border border-slate-600 px-3">{{ $info['number'] }}</td>
                                    <td class="border border-slate-600 px-3">{{ $info['email'] }}</td>
                                    {{-- <td
                                        class="border border-slate-600 px-3">
                                        {{ $info['total_money'] }} Taka</td>
                                    @php
                                        $totalMoney += $info['total_money'];
                                    @endphp --}}

                                </tr>
                            @endforeach


                        </tbody>
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
            <x-text-input id="role" class="block mt-1 w-full" readonly type="text" name="role" value="Customer" required autofocus autocomplete="role" />

        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>


        <!-- Numberr -->
        <div class="mt-4">
            <x-input-label for="number" :value="__('Number')" />
            <x-text-input id="number" class="block mt-1 w-full" type="text" name="number" :value="old('number')" required autocomplete="number" />
            <x-input-error :messages="$errors->get('number')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
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

