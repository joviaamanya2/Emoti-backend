<div class="flex flex-col h-screen w-64 shadow-lg">
    <!-- Top -->
    <div class="bg-green-600 text-white p-4 text-2xl font-bold">
        Emoti App
    </div>

    <!-- Menu -->
    <div class="flex-1 bg-white p-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="block p-2 rounded hover:bg-green-100">
            Dashboard
        </a>
        <a href="{{ route('admin.users') }}" class="block p-2 rounded hover:bg-green-100">
            Users
        </a>
        <a href="{{ route('admin.settings') }}" class="flex items-center p-2 rounded hover:bg-green-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
            </svg>
            Settings
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left block p-2 rounded hover:bg-green-100">
                Logout
            </button>
        </form>
    </div>
</div>