@php
    use Illuminate\Support\Str;
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl shadow-sm border border-emerald-100 overflow-hidden">
            <div class="px-6 py-5 bg-emerald-50 border-b border-emerald-100">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-base font-semibold text-emerald-900">Latest Testimonials</h3>
                        <p class="text-sm text-emerald-700">Recent approved feedback from your users.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                        {{ $totalTestimonials }} approved
                    </span>
                </div>
            </div>

            <div class="p-6 space-y-4">
                @forelse ($testimonials as $testimonial)
                    <div class="rounded-3xl border border-emerald-100 bg-emerald-50/60 p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-sm font-semibold text-emerald-900">{{ $testimonial->user_name ?? 'Anonymous' }}</div>
                                <div class="text-xs uppercase tracking-wide text-emerald-700">{{ $testimonial->session_type ?? 'Counseling Session' }}</div>
                            </div>
                            <div class="text-sm font-semibold text-amber-600">
                                {!! str_repeat('★', min(5, max(0, intval($testimonial->star_rating ?? 0)))) !!}
                                {!! str_repeat('☆', 5 - min(5, max(0, intval($testimonial->star_rating ?? 0)))) !!}
                            </div>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-700">{{ Str::limit($testimonial->description ?? $testimonial->what_worked ?? 'No description', 180) }}</p>
                        <div class="mt-4 text-xs text-slate-500">{{ optional($testimonial->created_at)->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-emerald-100 bg-emerald-50/60 p-4 text-sm text-slate-600">
                        No approved testimonials are available yet.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-emerald-100 overflow-hidden">
            <div class="px-6 py-5 bg-emerald-50 border-b border-emerald-100">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-base font-semibold text-emerald-900">Recent Journals</h3>
                        <p class="text-sm text-emerald-700">Fresh mood entries and reflections.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                        {{ $totalJournals }} total
                    </span>
                </div>
            </div>

            <div class="p-6 space-y-4">
                @forelse ($journals as $journal)
                    <div class="rounded-3xl border border-emerald-100 bg-emerald-50/60 p-4 shadow-sm">
                        <div class="text-sm font-semibold text-emerald-900">{{ $journal->title ?? 'Journal entry' }}</div>
                        <div class="mt-2 text-sm text-slate-700">{{ Str::limit($journal->content ?? 'No content available.', 180) }}</div>
                        <div class="mt-4 text-xs text-slate-500">{{ optional($journal->created_at)->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-emerald-100 bg-emerald-50/60 p-4 text-sm text-slate-600">
                        No journals have been posted yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

