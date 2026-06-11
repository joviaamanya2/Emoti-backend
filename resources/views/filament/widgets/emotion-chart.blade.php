<x-filament::widget>
    <x-filament::card class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-100 bg-gradient-to-r from-teal-50 to-white px-6 py-5">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">😊 Emotion Trends (Current Month)</h2>
                    <p class="mt-1 text-sm text-gray-500">Daily mood breakdown for {{ now()->format('F Y') }}</p>
                </div>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-teal-100 text-teal-600 text-lg">💡</span>
            </div>
        </div>
        <div class="flex items-center justify-center p-6">
            <div class="relative h-[500px] w-full md:w-[500px]">
                <canvas id="{{ $this->id }}"></canvas>
            </div>
        </div>
    </x-filament::card>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('{{ $this->id }}').getContext('2d');
            new Chart(ctx, {
                type: '{{ $this->getType() }}',
                data: @json($this->getData()),
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 14,
                                padding: 20,
                                font: { size: 13, weight: '500' },
                                color: '#4b5563',
                                usePointStyle: true,
                                pointStyleWidth: 10,
                            },
                        },
                        tooltip: {
                            backgroundColor: '#064e3b',
                            padding: 14,
                            cornerRadius: 10,
                            titleFont: { weight: 'bold', size: 14 },
                            bodyFont: { size: 13 },
                        },
                    },
                },
            });
        });
    </script>
</x-filament::widget>
