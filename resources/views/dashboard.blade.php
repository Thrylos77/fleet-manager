<x-layouts.app>
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight"
            :class="{ 'text-white': isDark, 'text-slate-900': !isDark }">Vue d'ensemble</h1>
        <p class="mt-1"
            :class="{ 'text-slate-400': isDark, 'text-slate-500': !isDark }">Gérez votre flotte et vos affectations en temps réel.</p>
    </div>

    <!-- Bento Grid Container -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Stat Card 1 -->
        <div class="col-span-1 lg:col-span-1 rounded-3xl p-6 shadow-xl hover:-translate-y-1 transition-all duration-300"
            :class="{
                'bg-fleet-800/60 backdrop-blur-md border border-fleet-700/50': isDark,
                'bg-white border border-slate-200 shadow-slate-200/50': !isDark
            }">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-fleet-accent/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-fleet-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <span class="text-sm font-semibold px-3 py-1 rounded-full"
                    :class="{ 'text-fleet-success bg-fleet-success/10': isDark, 'text-emerald-600 bg-emerald-50': !isDark }">+4%</span>
            </div>
            <h3 class="font-medium"
                :class="{ 'text-slate-400': isDark, 'text-slate-500': !isDark }">Véhicules Disponibles</h3>
            <p class="text-4xl font-bold mt-1"
                :class="{ 'text-white': isDark, 'text-slate-900': !isDark }">24<span class="text-lg font-normal"
                :class="{ 'text-slate-500': isDark, 'text-slate-400': !isDark }">/145</span></p>
        </div>

        <!-- Stat Card 2 -->
        <div class="col-span-1 lg:col-span-1 rounded-3xl p-6 shadow-xl hover:-translate-y-1 transition-all duration-300"
            :class="{
                'bg-fleet-800/60 backdrop-blur-md border border-fleet-700/50': isDark,
                'bg-white border border-slate-200 shadow-slate-200/50': !isDark
            }">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-fleet-warning/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-fleet-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="text-sm font-semibold px-3 py-1 rounded-full"
                    :class="{ 'text-fleet-danger bg-fleet-danger/10': isDark, 'text-red-600 bg-red-50': !isDark }">-2</span>
            </div>
            <h3 class="font-medium"
                :class="{ 'text-slate-400': isDark, 'text-slate-500': !isDark }">Chauffeurs en repos</h3>
            <p class="text-4xl font-bold mt-1"
                :class="{ 'text-white': isDark, 'text-slate-900': !isDark }">8</p>
        </div>

        <!-- Feature Card (Quick Action) -->
        <div class="col-span-1 md:col-span-2 lg:col-span-2 relative overflow-hidden bg-gradient-to-br from-fleet-accent to-fleet-glow border border-fleet-accent/30 rounded-3xl p-6 shadow-xl shadow-fleet-accent/20 group cursor-pointer">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <h3 class="text-xl font-bold text-white mb-2">Nouvelle Affectation</h3>
                    <p class="text-white/80">Affectez un chauffeur disponible à un véhicule immédiatement.</p>
                </div>
                <div class="mt-6 flex items-center text-white font-medium">
                    <span>Lancer l'assistant</span>
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
            </div>
        </div>

        <!-- Timeline (Recent Activity) -->
        <div class="col-span-1 md:col-span-2 lg:col-span-3 rounded-3xl p-6 shadow-xl"
            :class="{
                'bg-fleet-800/60 backdrop-blur-md border border-fleet-700/50': isDark,
                'bg-white border border-slate-200 shadow-slate-200/50': !isDark
            }">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold"
                    :class="{ 'text-white': isDark, 'text-slate-900': !isDark }">Activité Récente</h3>
                <button class="text-sm transition-colors"
                    :class="{ 'text-fleet-accent hover:text-white': isDark, 'text-indigo-600 hover:text-indigo-800': !isDark }">Tout voir</button>
            </div>

            <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5"
                :class="{ 'before:bg-gradient-to-b before:from-transparent before:via-fleet-700 before:to-transparent': isDark, 'before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent': !isDark }">
                <!-- Item 1 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full text-fleet-success shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2"
                        :class="{ 'border border-fleet-700 bg-fleet-800': isDark, 'border border-slate-200 bg-white': !isDark }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-2xl shadow-sm"
                        :class="{
                            'bg-fleet-800/50 border border-fleet-700/50': isDark,
                            'bg-slate-50 border border-slate-200': !isDark
                        }">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="font-bold text-sm"
                                :class="{ 'text-white': isDark, 'text-slate-900': !isDark }">Affectation créée</h4>
                            <time class="font-medium text-xs"
                                :class="{ 'text-slate-400': isDark, 'text-slate-400': !isDark }">Il y a 10 min</time>
                        </div>
                        <p class="text-sm"
                            :class="{ 'text-slate-400': isDark, 'text-slate-500': !isDark }">Le chauffeur <span
                            :class="{ 'text-slate-200': isDark, 'text-slate-700': !isDark }">Paul Dupont</span> a été affecté au véhicule <span class="text-fleet-accent">AB-123-CD</span>.</p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2"
                        :class="{ 'border border-fleet-700 bg-fleet-800 text-slate-400': isDark, 'border border-slate-200 bg-white text-slate-400': !isDark }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-2xl shadow-sm"
                        :class="{
                            'bg-fleet-800/50 border border-fleet-700/50': isDark,
                            'bg-slate-50 border border-slate-200': !isDark
                        }">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="font-bold text-sm"
                                :class="{ 'text-white': isDark, 'text-slate-900': !isDark }">Fin d'affectation</h4>
                            <time class="font-medium text-xs"
                                :class="{ 'text-slate-400': isDark, 'text-slate-400': !isDark }">Hier</time>
                        </div>
                        <p class="text-sm"
                            :class="{ 'text-slate-400': isDark, 'text-slate-500': !isDark }">Le véhicule <span class="text-fleet-accent">XY-999-ZZ</span> a été retourné au garage.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info Widget -->
        <div class="col-span-1 lg:col-span-1 space-y-6">
            <div class="rounded-3xl p-6 shadow-xl"
                :class="{
                    'bg-fleet-800/60 backdrop-blur-md border border-fleet-700/50': isDark,
                    'bg-white border border-slate-200 shadow-slate-200/50': !isDark
                }">
                <h3 class="text-lg font-bold mb-4"
                    :class="{ 'text-white': isDark, 'text-slate-900': !isDark }">À revoir</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-fleet-danger"></div>
                        <p class="text-sm"
                            :class="{ 'text-slate-300': isDark, 'text-slate-600': !isDark }"><span class="font-bold"
                            :class="{ 'text-white': isDark, 'text-slate-900': !isDark }">2 permis</span> expirent ce mois-ci.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-fleet-warning"></div>
                        <p class="text-sm"
                            :class="{ 'text-slate-300': isDark, 'text-slate-600': !isDark }"><span class="font-bold"
                            :class="{ 'text-white': isDark, 'text-slate-900': !isDark }">5 véhicules</span> inactifs depuis 30 jours.</p>
                    </div>
                </div>
                <button class="mt-6 w-full py-2 text-sm font-medium rounded-xl transition-colors"
                    :class="{
                        'bg-fleet-700 hover:bg-fleet-600 text-white': isDark,
                        'bg-slate-100 hover:bg-slate-200 text-slate-700': !isDark
                    }">
                    Consulter les alertes
                </button>
            </div>
        </div>
    </div>
</x-layouts.app>
