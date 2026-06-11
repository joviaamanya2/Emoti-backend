<x-filament::layout>
    <x-slot name="header">
        <div style="font-weight:700;">Sign in</div>
    </x-slot>

    <x-filament::card>
        <form method="POST" action="{{ route('filament.auth.login') }}">
            @csrf
            <x-filament::input placeholder="Email" type="email" name="email" required autofocus />
            <x-filament::input placeholder="Password" type="password" name="password" required />

            <x-filament::button type="submit" class="mt-4">
                Login
            </x-filament::button>
        </form>
    </x-filament::card>
</x-filament::layout>

