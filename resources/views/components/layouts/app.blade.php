<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="themeManager()" x-bind:class="{ 'dark': isDark, 'light': !isDark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FleetManager') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .theme-transition,
        .theme-transition *,
        .theme-transition *::before,
        .theme-transition *::after {
            transition: all 0.3s ease-in-out !important;
        }
    </style>
</head>
<body class="font-sans antialiased selection:bg-fleet-accent selection:text-white relative overflow-hidden"
    x-init="$el.classList.remove('theme-transition')"
    :class="{
        'bg-fleet-900 text-slate-100': isDark,
        'bg-slate-100 text-slate-800': !isDark,
        'theme-transition': true
    }"
    x-data="{ sidebarOpen: true }">

    <!-- Background Mesh Gradient effect -->
    <div class="fixed inset-0 z-0 pointer-events-none"
        :class="{ 'bg-mesh-gradient opacity-40': isDark, 'opacity-0': !isDark }"></div>

    <div class="relative z-10 flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <x-navigation.sidebar />

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden transition-all duration-300">
            <!-- Floating Navbar -->
            <x-navigation.floating-navbar />

            <!-- Main Page Content -->
            <main class="flex-1 overflow-y-auto p-6 animate-fade-in-up">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>
