<x-filament::widget>
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-xl font-bold text-gray-900">Dashboard Overview</h2>
            <p class="mt-1 text-sm text-gray-500">Quick summary of your platform activity</p>
        </div>
        <div class="grid gap-4 xl:grid-cols-5 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 p-6">
            @php
                $cards = [
                    ['label' => 'Total Users', 'value' => $totalUsers, 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-100', 'icon' => '👥', 'subtitle' => 'All registered users'],
                    ['label' => 'Appointments', 'value' => $appointments, 'bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-100', 'icon' => '📅', 'subtitle' => 'Booked sessions'],
                    ['label' => 'Recommendations', 'value' => $recommendations, 'bg' => 'bg-yellow-50', 'text' => 'text-yellow-600', 'border' => 'border-yellow-100', 'icon' => '⭐', 'subtitle' => 'Suggested actions'],
                    ['label' => 'Feedbacks', 'value' => $feedbacks, 'bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'border' => 'border-purple-100', 'icon' => '💬', 'subtitle' => 'User responses'],
                    ['label' => 'Journals', 'value' => $journals, 'bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'border' => 'border-rose-100', 'icon' => '📔', 'subtitle' => 'Mood & wellbeing notes'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="overflow-hidden rounded-2xl border {{ $card['border'] }} bg-white shadow-sm">
                    <div class="px-6 py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ $card['label'] }}</p>
                                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ number_format($card['value']) }}</p>
                            </div>
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl {{ $card['bg'] }} {{ $card['text'] }} text-lg">
                                {{ $card['icon'] }}
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-gray-500">{{ $card['subtitle'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament::widget>
