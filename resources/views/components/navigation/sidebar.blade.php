<aside
    class="flex-shrink-0 hidden md:flex flex-col transition-all duration-300"
    :class="{
        'bg-fleet-800/80 backdrop-blur-xl border-r border-fleet-700/50': isDark,
        'bg-white/80 backdrop-blur-xl border-r border-slate-200': !isDark
    }"
    :style="sidebarOpen ? 'width: 16rem' : 'width: 5rem'"
>
    <!-- Logo Section -->
    <div class="h-20 flex items-center justify-center border-b"
        :class="{ 'border-fleet-700/50': isDark, 'border-slate-200': !isDark }">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-fleet-accent to-fleet-glow flex items-center justify-center shadow-lg shadow-fleet-accent/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <span class="text-xl font-bold tracking-wider"
                :class="{ 'text-white': isDark, 'text-slate-800': !isDark }"
                x-show="sidebarOpen" x-transition>Fleet</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-2">
        <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-colors border"
            :class="{
                'bg-fleet-accent/10 text-fleet-accent border-fleet-accent/20': isDark,
                'bg-indigo-50 text-indigo-600 border-indigo-200': !isDark
            }">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span x-show="sidebarOpen" x-transition>Dashboard</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-colors group"
            :class="{ 'hover:bg-fleet-700/50 text-slate-300 hover:text-white': isDark, 'hover:bg-slate-100 text-slate-500 hover:text-slate-800': !isDark }">
            <svg class="w-6 h-6 transition-colors" :class="{ 'group-hover:text-fleet-glow': isDark, 'group-hover:text-indigo-500': !isDark }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            <span x-show="sidebarOpen" x-transition>Affectations</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-colors group"
            :class="{ 'hover:bg-fleet-700/50 text-slate-300 hover:text-white': isDark, 'hover:bg-slate-100 text-slate-500 hover:text-slate-800': !isDark }">
            <svg class="w-6 h-6 transition-colors" :class="{ 'group-hover:text-fleet-glow': isDark, 'group-hover:text-indigo-500': !isDark }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <span x-show="sidebarOpen" x-transition>Véhicules</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-colors group"
            :class="{ 'hover:bg-fleet-700/50 text-slate-300 hover:text-white': isDark, 'hover:bg-slate-100 text-slate-500 hover:text-slate-800': !isDark }">
            <svg class="w-6 h-6 transition-colors" :class="{ 'group-hover:text-fleet-glow': isDark, 'group-hover:text-indigo-500': !isDark }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span x-show="sidebarOpen" x-transition>Chauffeurs</span>
        </a>
    </nav>
</aside>
