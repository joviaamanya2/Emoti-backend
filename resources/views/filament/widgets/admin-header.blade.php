<x-filament::widget>
    <x-filament::card class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">{{ $appName }}</h1>
                <p class="mt-1 text-emerald-100">Welcome to the admin control center</p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold">{{ $totalUsers }}</div>
                <div class="text-sm text-emerald-100">Total Users</div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
