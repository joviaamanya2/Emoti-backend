@php
    // We render client-side because the endpoints are already provided for the mobile/frontend.
    // This keeps the dashboard lightweight and always fresh.
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-green-100 p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-bold text-emerald-700">Testimonials</h3>
                <span class="text-xs text-emerald-600" id="testimonials-count">Loading...</span>
            </div>

            <div class="space-y-3" id="testimonials-list">
                <div class="text-sm text-gray-500">Fetching testimonials...</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-green-100 p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-bold text-emerald-700">Journals</h3>
                <span class="text-xs text-emerald-600" id="journals-count">Loading...</span>
            </div>

            <div class="space-y-3" id="journals-list">
                <div class="text-sm text-gray-500">Fetching journals...</div>
            </div>
        </div>
    </div>
</div>

<script>
    async function fetchJson(url) {
        const res = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                // If your app requires auth for these endpoints, uncomment next line:
                // 'Authorization': 'Bearer ' + (localStorage.getItem('token') || '')
            },
        });
        if (!res.ok) throw new Error(`Request failed: ${res.status}`);
        return await res.json();
    }

    function escapeHtml(str) {
        return String(str)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '<')
            .replaceAll('>', '>')
            .replaceAll('"', '"')
            .replaceAll("'", '&#039;');
    }

    function starsHtml(starRating) {
        const r = Number(starRating || 0);
        const full = Math.max(0, Math.min(5, r));
        let s = '';
        for (let i = 1; i <= 5; i++) {
            const color = i <= full ? '#10b981' : '#d1d5db';
            s += `<span style="color:${color}">★</span>`;
        }
        return s;
    }

    (async function () {
        try {
            // Testimonials: /api/testimonials returns {success:true,data:[...]}
            const t = await fetchJson('/api/testimonials?limit=5');
            const items = t?.data || [];
            document.getElementById('testimonials-count').textContent = items.length + ' items';
            const list = document.getElementById('testimonials-list');

            if (!items.length) {
                list.innerHTML = '<div class="text-sm text-gray-500">No testimonials found.</div>';
            } else {
                list.innerHTML = items.map(item => {
                    return `
                        <div class="p-3 rounded-lg border border-emerald-100 bg-emerald-50/30">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="text-sm font-semibold text-emerald-800">${escapeHtml(item.user_name || 'Anonymous')}</div>
                                    <div class="text-xs text-emerald-700">${escapeHtml(item.session_type || 'General')}</div>
                                </div>
                                <div class="text-xs">${starsHtml(item.star_rating)}</div>
                            </div>
                            <div class="mt-2 text-sm text-gray-800">
                                ${escapeHtml(item.description || '')}
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                ${item.created_at ? escapeHtml(item.created_at) : ''}
                            </div>
                        </div>
                    `;
                }).join('');
            }

            // Journals: /api/journals returns journals array (Journal model must exist)
            const j = await fetchJson('/api/journals');
            const journals = Array.isArray(j) ? j : (j?.data || []);
            document.getElementById('journals-count').textContent = journals.length + ' items';
            const jList = document.getElementById('journals-list');

            if (!journals.length) {
                jList.innerHTML = '<div class="text-sm text-gray-500">No journals found.</div>';
            } else {
                jList.innerHTML = journals.slice(0, 5).map(row => {
                    // Journal schema unknown; render safe fields.
                    const userName = row?.user?.name || row?.user_name || '';
                    const title = row?.title || row?.subject || row?.heading || '';
                    const body = row?.content || row?.description || row?.text || '';

                    return `
                        <div class="p-3 rounded-lg border border-emerald-100 bg-emerald-50/30">
                            <div class="text-sm font-semibold text-emerald-800">${escapeHtml(userName || 'User')}</div>
                            ${title ? `<div class="text-xs text-emerald-700">${escapeHtml(title)}</div>` : ''}
                            ${body ? `<div class="mt-2 text-sm text-gray-800">${escapeHtml(body)}</div>` : ''}
                            <div class="mt-2 text-xs text-gray-500">${row.created_at ? escapeHtml(row.created_at) : ''}</div>
                        </div>
                    `;
                }).join('');
            }
        } catch (e) {
            console.error(e);
            document.getElementById('testimonials-list').innerHTML = '<div class="text-sm text-red-600">Failed to load testimonials.</div>';
            document.getElementById('journals-list').innerHTML = '<div class="text-sm text-red-600">Failed to load journals.</div>';
        }
    })();
</script>

