<x-filament::widget>
    <x-filament::card>
        <h2 class="text-lg font-bold text-gray-700 mb-2">{{ $this->getHeading() }}</h2>
        <canvas id="{{ $this->id }}"></canvas>
    </x-filament::card>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('{{ $this->id }}').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: @json($this->getData()),
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true }
                    }
                }
            });
        });
    </script>
</x-filament::widget>