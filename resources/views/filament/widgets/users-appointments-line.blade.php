<x-filament::widget>
    <div class="grid gap-4 grid-cols-2">
        <x-filament::card class="border-l-4 border-l-emerald-500 bg-emerald-50/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Users</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-900">{{ $totalUsers }}</p>
                </div>
                <div class="text-4xl">👥</div>
            </div>
            <p class="mt-3 text-xs text-slate-500">All registered app users</p>
        </x-filament::card>

        <x-filament::card class="border-l-4 border-l-blue-500 bg-blue-50/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Appointments</p>
                    <p class="mt-2 text-3xl font-bold text-blue-900">{{ $totalAppointments }}</p>
                </div>
                <div class="text-4xl">📅</div>
            </div>
            <p class="mt-3 text-xs text-slate-500">Total booked sessions</p>
        </x-filament::card>
    </div>
</x-filament::widget>
