<header class="px-6 py-4 z-20 sticky top-0">
    <div class="rounded-2xl shadow-lg shadow-black/20 flex items-center justify-between px-6 py-3 transition-all duration-300"
        :class="{
            'bg-fleet-800/60 backdrop-blur-md border border-fleet-700/50': isDark,
            'bg-white/80 backdrop-blur-md border border-slate-200 shadow-slate-200/50': !isDark
        }">

        <!-- Left Side: Toggle & Search -->
        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl transition-colors focus:outline-none"
                :class="{ 'text-slate-400 hover:text-white hover:bg-fleet-700/50': isDark, 'text-slate-500 hover:text-slate-800 hover:bg-slate-100': !isDark }">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
            </button>

            <div class="hidden md:flex relative group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none transition-colors"
                    :class="{ 'text-slate-400 group-focus-within:text-fleet-accent': isDark, 'text-slate-400 group-focus-within:text-indigo-500': !isDark }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" class="text-sm rounded-xl focus:ring-2 block w-64 pl-10 p-2.5 transition-all placeholder-slate-500"
                    :class="{
                        'bg-fleet-900/50 border border-fleet-700/50 text-slate-200 focus:ring-fleet-accent focus:border-fleet-accent': isDark,
                        'bg-slate-100 border border-slate-200 text-slate-800 focus:ring-indigo-500 focus:border-indigo-500': !isDark
                    }" placeholder="Rechercher...">
            </div>
        </div>

        <!-- Right Side: Theme Toggle, Notifications & Profile -->
        <div class="flex items-center gap-3">
            <!-- Theme Toggle -->
            <button @click="toggleTheme()" class="p-2 rounded-xl transition-colors focus:outline-none"
                :class="{ 'text-slate-400 hover:text-white hover:bg-fleet-700/50': isDark, 'text-slate-500 hover:text-slate-800 hover:bg-slate-100': !isDark }"
                x-tooltip.raw="Changer le thème">
                <template x-if="isDark">
                    <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </template>
                <template x-if="!isDark">
                    <svg class="w-5 h-5 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </template>
            </button>

            <!-- Notifications -->
            <button class="relative p-2 transition-colors"
                :class="{ 'text-slate-400 hover:text-white': isDark, 'text-slate-500 hover:text-slate-800': !isDark }">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-1 right-2 flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-fleet-danger opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-fleet-danger"></span>
                </span>
            </button>

            <!-- Profile Dropdown (Alpine) -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-r from-fleet-accent to-fleet-glow p-0.5">
                        <div class="w-full h-full rounded-full flex items-center justify-center"
                            :class="{ 'bg-fleet-800': isDark, 'bg-white': !isDark }">
                            <span class="text-sm font-bold"
                                :class="{ 'text-white': isDark, 'text-fleet-accent': !isDark }">AD</span>
                        </div>
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-medium leading-none"
                            :class="{ 'text-white': isDark, 'text-slate-800': !isDark }">Admin</p>
                        <p class="text-xs mt-1"
                            :class="{ 'text-slate-400': isDark, 'text-slate-500': !isDark }">Fleet Manager</p>
                    </div>
                    <svg class="w-4 h-4"
                        :class="{ 'text-slate-400': isDark, 'text-slate-500': !isDark }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 mt-3 w-48 backdrop-blur-xl border shadow-xl py-2 z-50 rounded-xl"
                    :class="{
                        'bg-fleet-800/90 border-fleet-700/50': isDark,
                        'bg-white/90 border-slate-200': !isDark
                    }" style="display: none;">
                    <a href="#" class="block px-4 py-2 text-sm transition-colors"
                        :class="{ 'text-slate-300 hover:bg-fleet-700/50 hover:text-white': isDark, 'text-slate-600 hover:bg-slate-100 hover:text-slate-900': !isDark }">Mon Profil</a>
                    <a href="#" class="block px-4 py-2 text-sm transition-colors"
                        :class="{ 'text-slate-300 hover:bg-fleet-700/50 hover:text-white': isDark, 'text-slate-600 hover:bg-slate-100 hover:text-slate-900': !isDark }">Paramètres</a>
                    <div class="border-t my-1"
                        :class="{ 'border-fleet-700/50': isDark, 'border-slate-200': !isDark }"></div>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm transition-colors"
                            :class="{ 'text-fleet-danger hover:bg-fleet-700/50': isDark, 'text-red-600 hover:bg-slate-100': !isDark }">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
