<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="themeManager()" x-bind:class="{ 'dark': isDark, 'light': !isDark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FleetManager') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

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
<body class="font-sans antialiased min-h-screen"
    x-init="$el.classList.remove('theme-transition')"
    :class="{
        'bg-fleet-900 text-slate-100': isDark,
        'bg-slate-50 text-slate-800': !isDark,
        'theme-transition': true
    }"
>
    {{ $slot }}
</body>
</html>
