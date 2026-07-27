<x-guest-layout>
    <div class="min-h-screen relative flex items-center justify-center p-4 sm:p-6 lg:p-8"
        :class="{ 'bg-fleet-900': isDark, 'bg-slate-50': !isDark }">

        <!-- ============================================================
             BACKGROUND — Mesh Gradient + Halos lumineux
             ============================================================ -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Dark mode : bleu nuit, indigo, violet -->
            <div x-show="isDark" class="absolute inset-0"
                x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100">
                <div class="absolute -top-48 -right-48 w-[30rem] h-[30rem] rounded-full bg-indigo-600/10 blur-[120px]"></div>
                <div class="absolute -bottom-48 -left-48 w-[28rem] h-[28rem] rounded-full bg-purple-600/10 blur-[120px]"></div>
                <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[24rem] h-[24rem] rounded-full bg-fleet-accent/5 blur-[100px]"></div>
                <div class="absolute top-1/4 right-1/4 w-96 h-96 rounded-full bg-blue-500/5 blur-[100px]"></div>
                <!-- Grain texture overlay très subtil -->
                <div class="absolute inset-0 opacity-[0.03]" style="background-image: url(\"data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E\");"></div>
            </div>

            <!-- Light mode : blanc cassé, gris très clair, touches de indigo -->
            <div x-show="!isDark" class="absolute inset-0"
                x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100">
                <div class="absolute -top-48 -right-48 w-[30rem] h-[30rem] rounded-full bg-indigo-200/40 blur-[120px]"></div>
                <div class="absolute -bottom-48 -left-48 w-[28rem] h-[28rem] rounded-full bg-purple-200/40 blur-[120px]"></div>
                <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[24rem] h-[24rem] rounded-full bg-fleet-accent/10 blur-[100px]"></div>
                <div class="absolute top-1/4 right-1/4 w-96 h-96 rounded-full bg-blue-200/30 blur-[100px]"></div>
                <div class="absolute inset-0 opacity-[0.02]" style="background-image: url(\"data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E\");"></div>
            </div>
        </div>

        <!-- ============================================================
             CARTE GLASSMORPHISM (max-w-[440px])
             ============================================================ -->
        <div class="relative z-10 w-full max-w-[440px] rounded-2xl transition-all duration-300"
            :class="{
                'bg-fleet-800/40 backdrop-blur-xl border border-fleet-700/30 shadow-2xl shadow-black/30': isDark,
                'bg-white/70 backdrop-blur-xl border border-white/50 shadow-xl shadow-slate-200/60': !isDark
            }">

            <div class="p-8 sm:p-10">
                <!-- Logo -->
                <div class="mb-8 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-fleet-accent to-fleet-glow shadow-lg shadow-fleet-accent/20 mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-semibold tracking-tight"
                        :class="{ 'text-white': isDark, 'text-slate-900': !isDark }">
                        Connexion
                    </h1>
                    <p class="mt-1 text-sm"
                        :class="{ 'text-slate-400': isDark, 'text-slate-500': !isDark }">
                        Accédez à votre tableau de bord
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium mb-1.5"
                            :class="{ 'text-slate-300': isDark, 'text-slate-700': !isDark }">
                            Nom d'utilisateur
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"
                                :class="{ 'text-slate-400': isDark, 'text-slate-400': !isDark }">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="username" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" placeholder="Votre nom d'utilisateur"
                                class="block w-full pl-10 pr-4 py-2.5 rounded-xl text-sm transition-all duration-200 border"
                                :class="{
                                    'bg-fleet-900/60 border-fleet-700/50 text-white placeholder-slate-500 focus:border-fleet-accent focus:ring-1 focus:ring-fleet-accent/40': isDark,
                                    'bg-white/80 border-slate-200 text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30': !isDark
                                }">
                        </div>
                        <x-input-error :messages="$errors->get('username')" class="mt-1.5" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium mb-1.5"
                            :class="{ 'text-slate-300': isDark, 'text-slate-700': !isDark }">
                            Mot de passe
                        </label>
                        <div class="relative" x-data="{ showPassword: false }">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none"
                                :class="{ 'text-slate-400': isDark, 'text-slate-400': !isDark }">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                                class="block w-full pl-10 pr-12 py-2.5 rounded-xl text-sm transition-all duration-200 border"
                                :class="{
                                    'bg-fleet-900/60 border-fleet-700/50 text-white placeholder-slate-500 focus:border-fleet-accent focus:ring-1 focus:ring-fleet-accent/40': isDark,
                                    'bg-white/80 border-slate-200 text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30': !isDark
                                }">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5"
                                :class="{ 'text-slate-400 hover:text-white': isDark, 'text-slate-400 hover:text-slate-600': !isDark }">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="rounded-lg border transition-all duration-200"
                                :class="{
                                    'border-fleet-700/50 bg-fleet-900/60 text-fleet-accent focus:ring-fleet-accent/40': isDark,
                                    'border-slate-300 bg-white text-indigo-600 focus:ring-indigo-500/30': !isDark
                                }">
                            <span class="text-sm"
                                :class="{ 'text-slate-400': isDark, 'text-slate-600': !isDark }">
                                Se souvenir de moi
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-medium transition-colors"
                            :class="{ 'text-fleet-accent hover:text-fleet-glow': isDark, 'text-indigo-600 hover:text-indigo-800': !isDark }">
                            Mot de passe oublié ?
                        </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 shadow-lg"
                        :class="{
                            'bg-gradient-to-r from-fleet-accent to-fleet-glow focus:ring-fleet-accent/50 focus:ring-offset-fleet-800 shadow-fleet-accent/20': isDark,
                            'bg-gradient-to-r from-indigo-600 to-purple-600 focus:ring-indigo-500/50 focus:ring-offset-white shadow-indigo-500/20': !isDark
                        }">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Se connecter
                        </span>
                    </button>

                    <!-- Theme Toggle -->
                    <div class="pt-5 border-t text-center"
                        :class="{ 'border-fleet-700/30': isDark, 'border-slate-200/70': !isDark }">
                        <button type="button" @click="toggleTheme()"
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200"
                            :class="{
                                'text-slate-400 hover:text-white hover:bg-fleet-700/50': isDark,
                                'text-slate-500 hover:text-slate-800 hover:bg-slate-200/50': !isDark
                            }">
                            <template x-if="isDark">
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </template>
                            <template x-if="!isDark">
                                <svg class="w-4 h-4 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                            </template>
                            <span x-text="isDark ? 'Mode Clair' : 'Mode Sombre'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer crédit discret -->
        <p class="absolute bottom-4 left-1/2 -translate-x-1/2 text-xs z-10"
            :class="{ 'text-slate-600': isDark, 'text-slate-400': !isDark }">
            FleetManager &mdash; Gestion de parc automobile
        </p>
    </div>
</x-guest-layout>
