<x-filament::widget>
    <x-filament::card class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-white px-6 py-5">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">👥 New Users This Month</h2>
                    <p class="mt-1 text-sm text-gray-500">Daily sign-up trends for {{ now()->format('F Y') }}</p>
                </div>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 text-lg">📊</span>
            </div>
        </div>
        <div class="p-6">
            <div class="relative h-[500px] w-full">
                <canvas id="{{ $this->id }}"></canvas>
            </div>
        </div>
    </x-filament::card>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('{{ $this->id }}').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: @json($this->getData()),
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 20,
                                font: { size: 13 },
                                color: '#6b7280',
                            },
                        },
                        tooltip: {
                            backgroundColor: '#064e3b',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: { weight: 'bold' },
                        },
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Day of Month',
                                color: '#6b7280',
                                font: { size: 13, weight: '600' },
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.04)',
                            },
                            ticks: {
                                color: '#9ca3af',
                                font: { size: 12 },
                            },
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of New Users',
                                color: '#6b7280',
                                font: { size: 13, weight: '600' },
                            },
                            ticks: {
                                precision: 0,
                                color: '#9ca3af',
                                font: { size: 12 },
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.04)',
                            },
                        },
                    },
                },
            });
        });
    </script>
</x-filament::widget>
