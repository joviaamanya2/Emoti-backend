<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Enter the 6-digit code sent to your email to verify your request.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.verify_otp') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email', session('otp_email')) }}" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="otp" :value="__('Verification code (OTP)')" />
            <x-text-input id="otp" class="block mt-1 w-full" type="text" inputmode="numeric" name="otp" value="{{ old('otp') }}" required autocomplete="one-time-code" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex justify-end">
            <x-primary-button>
                {{ __('Verify Code') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

