<x-app-layout>
    <x-slot name="header">
        <div class=" d-flex align-items-center ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-grow-1">
                {{ __('Banglalink') }}
            </h2>
            <button type="button" class="btn btn-sm bg-[#e96c41] hover:bg-[#f69274] mb-2" data-bs-toggle="modal"
                data-bs-target="#addPack">
                Add Package
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <table class="table table-striped table-secondary" id="dataTable">
                        <thead>
                            <tr>
                                <th>Package Name</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Validity</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banglalink as $data)
                                <tr>
                                    <td>{{ $data->packName }}</td>
                                    <td>{{ $data->title }}</td>
                                    <td>{{ $data->price }}</td>

                                    <td>{{ $data->validity == 0 ? 'Unlimited' : $data->validity }}</td>
                                    {{-- <td>
                                        <a href="{{ route('editAirtel', $data->id) }}" class="btn btn-sm btn-dark bg-slate-600">Edit</a>
                                        <a href="{{ route('deleteAirtel', $data->id) }}" class="btn btn-sm btn-dark bg-slate-600">Delete</a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>


<x-i_modal title="Add Package" id="addPack">

    <form action="{{ route('addBanglalink') }}" method="POST">
        @csrf

        <div class="mt-2">
            <x-input-label for="packName" value="Package name" />
            <select class="form-select mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" aria-label="Default select example" name="packName">
                <option selected>Package Name</option>

                @php
                    $data = ['Internet', 'Minutes', 'Combo', 'Call Rate'];
                @endphp

                @foreach ($data as $name)
                    <option value="{{ $name }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-2">
            <x-input-label for="title" value="Title" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')"
                required autofocus />
        </div>
        <div class="mt-2">
            <x-input-label for="price" value="Price" />
            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" min="0"
                :value="old('price')" required autofocus />
        </div>
        <div class="mt-2">
            <x-input-label for="validity" value="Validity [ 0 for Unlimited ]" />
            <x-text-input id="validity" class="block mt-1 w-full" type="number" min="0" name="validity"
                :value="old('validity')" required autofocus />
        </div>
        <div class="mt-2">
            <input type="submit" value="Insert"
                class="btn btn-sm bg-[#e96c41] hover:bg-[#f69274] mt-1 mb-1 float-end text-light">
        </div>
    </form>

</x-i_modal>
