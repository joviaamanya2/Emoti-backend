<x-filament::widget>
    <x-filament::card class="bg-emerald-50 border-emerald-100 text-slate-900 shadow-sm">
        <div class="space-y-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-emerald-900">Recent Insight</h2>
                    <p class="text-sm text-emerald-700">Live mood and schedule analysis for the current period.</p>
                </div>
                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-800">Live</span>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl border border-emerald-100 bg-white p-4 shadow-sm">
                    <div class="text-sm font-semibold text-emerald-900">Top Emotion</div>
                    <div class="mt-2 text-2xl font-bold text-slate-900">{{ $topEmotion }}</div>
                    <div class="mt-1 text-xs uppercase tracking-wide text-slate-500">{{ $topEmotionCount }} logs this month</div>
                </div>

                <div class="rounded-3xl border border-emerald-100 bg-white p-4 shadow-sm">
                    <div class="text-sm font-semibold text-emerald-900">Busiest Day</div>
                    <div class="mt-2 text-2xl font-bold text-slate-900">{{ $busiestDay }}</div>
                    <div class="mt-1 text-xs uppercase tracking-wide text-slate-500">Most appointments</div>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl border border-emerald-100 bg-white p-4 shadow-sm">
                    <div class="text-sm font-semibold text-emerald-900">Happy Share</div>
                    <div class="mt-2 text-2xl font-bold text-slate-900">{{ $happyPercent }}%</div>
                    <div class="mt-1 text-xs uppercase tracking-wide text-slate-500">of all mood logs</div>
                </div>

                <div class="rounded-3xl border border-emerald-100 bg-white p-4 shadow-sm">
                    <div class="text-sm font-semibold text-emerald-900">New Users Today</div>
                    <div class="mt-2 text-2xl font-bold text-slate-900">{{ $todayNewUsers }}</div>
                    <div class="mt-1 text-xs uppercase tracking-wide text-slate-500">new signups in 24h</div>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
