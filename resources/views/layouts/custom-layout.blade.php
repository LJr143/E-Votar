<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('E-votar') }}</title>

    <link rel="shortcut icon" href="{{ asset('storage/assets/icon/evotar_v_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>


    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&amp;display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>



    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-poppins antialiased">
@livewire('privacy-agreement')
<x-banner />

<header>
    {{ $wheader ?? '' }} <!-- Render the header slot -->
</header>

<main>
    {{ $main }} <!-- This is where the content of the child views will be injected -->
</main>

<footer>
    {{ $wfooter ?? '' }} <!-- Render the header slot -->
</footer>
@stack('modals')

@livewireScripts
</body>
</html>
