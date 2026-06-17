<div class="flex flex-col h-screen w-64 shadow-lg bg-white">
    <!-- Brand -->
    <div class="admin-sidebar-header bg-emerald-600 text-white p-4 text-2xl font-bold tracking-wide">
        Emoti App
    </div>

    <!-- Menu -->
    <div class="flex-1 p-4 space-y-4">
        <!-- Dashboard -->
        <div class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-green-50 text-gray-800 transition">
                <span class="inline-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 0v10h6V10" />
                    </svg>
                </span>
                <span class="font-medium">Dashboard</span>
            </a>
        </div>

        <!-- User Management -->
        <div class="space-y-2">
            <div class="text-xs font-semibold uppercase tracking-wider text-green-700">User Management</div>

            <a href="{{ route('admin.users') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-green-50 transition text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11a4 4 0 100-8 4 4 0 000 8z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21v-2a4 4 0 00-3-3.87" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3a4 4 0 010 8" />
                </svg>
                <span class="font-medium">Users</span>
            </a>

            <a href="{{ route('admin.admins') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-green-50 transition text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">Admins</span>
            </a>
        </div>

        <!-- Counseling -->
        <div class="space-y-2">
            <div class="text-xs font-semibold uppercase tracking-wider text-green-700">Counseling</div>

            <a href="{{ url(config('filament.path', 'admin').'/counselor-sessions') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-green-50 transition text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="font-medium">Counselor Session</span>
            </a>
        </div>

        <!-- User content -->
        <div class="space-y-2">
            <div class="text-xs font-semibold uppercase tracking-wider text-green-700">User content</div>

            <a href="{{ route('admin.journals') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-green-50 transition text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4H5a2 2 0 00-2 2v14a2 2 0 002 2h11a2 2 0 002-2V8l-2-4z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v4h4" />
                </svg>
                <span class="font-medium">Journals</span>
            </a>

            <a href="{{ route('admin.feedbacks') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-green-50 transition text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a4 4 0 01-4 4H8l-5 3V7a4 4 0 014-4h10a4 4 0 014 4v8z" />
                </svg>
                <span class="font-medium">Feedback</span>
            </a>
        </div>

        <!-- Content library -->
        <div class="space-y-2">
            <div class="text-xs font-semibold uppercase tracking-wider text-green-700">Content library</div>

            <a href="{{ route('admin.videos') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-green-50 transition text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618V15.38a1 1 0 01-1.447.894L15 14V10z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 7H4a2 2 0 00-2 2v6a2 2 0 002 2h7V7z" />
                </svg>
                <span class="font-medium">Videos</span>
            </a>

            <a href="{{ route('admin.games') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-green-50 transition text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 14l7-7" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h6v6" />
                </svg>
                <span class="font-medium">Games</span>
            </a>

            <a href="{{ route('admin.storybooks') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-green-50 transition text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                </svg>
                <span class="font-medium">Story books</span>
            </a>
        </div>

        <!-- Settings / Logout -->
        <div class="space-y-2 pt-2 border-t border-gray-100">
            <a href="{{ route('admin.settings') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-green-50 transition text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15.5A3.5 3.5 0 1112 8.5a3.5 3.5 0 010 7z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V22a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 005 15.4a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009.6 5a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019 10.6c.02.32.02.67 0 1z" />
                </svg>
                <span class="font-medium">Settings</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-green-50 transition text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12H3" />
                    </svg>
                    <span class="font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>

