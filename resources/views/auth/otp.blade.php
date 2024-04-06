<x-guest-layout>
    <div class="mt-4">
        @if (session('error'))
            <div class="text-red-500">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('verifyOtp') }}">
            @csrf

            <div class="mb-4">
                <label for="otp" class="block text-sm font-medium text-gray-700">OTP</label>
                <input type="text" name="otp" id="otp" class="mt-1 p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full shadow-sm">
                <x-input-error :messages="$errors->get('otp')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 text-white font-semibold px-4 py-2 rounded focus:outline-none focus:shadow-outline hover:bg-blue-600">Verify OTP</button>
            </div>
        </form>
    </div>
</x-guest-layout>
