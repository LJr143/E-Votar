@props(['mainClass' => '', 'bodyClass' => '', 'headerClass' => '','page_title' => ' '])
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>USeP E-Votar {{ $page_title }}</title>

    <link rel="shortcut icon" href="{{ asset('storage/assets/icon/evotar_v_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

    <link href="https://unpkg.com/@pqina/flip/dist/flip.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-barlow antialiased bg-[#F7F7F9]">

@if(session('showSplash'))
    <div id="splash-screen" class="splash-screen">
        <div class="loading-line"></div>
        <h1>E-VOTAR @2025</h1>
    </div>
@endif

<div class="min-h-screen max-w-screen-2xl mx-auto bg-[#F7F7F9] {{ $mainClass }}">
    @if (isset($sidebar))
        {{-- Sidebar --}}
        <sidebar class="h-screen w-[290px]  flex flex-col shadow z-10">
            {{ $sidebar }}
        </sidebar>
    @endif
    <div class="h-screen w-full flex flex-col {{ $bodyClass }}"

         x-on:election-created.window="pushNotification('success', 'Election Created', 'Election has been create successfully.');">

        <!-- Page Heading -->
        @if (isset($header))
            <header class="flex pt-2 {{ $headerClass }}">
                <div class=" px-4 py-2 sm:px-6 h-[50px] w-full justify-between items-center flex">
                    {{ $header }}
                </div>
            </header>
        @endif
        @if (isset($main))
            <!-- Page Content -->
            <main class="relative flex-1 max-lg:h-dvh lg:overflow-y-auto  w-full px-6 pt-2 ">
                {{ $main }}
                <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
                <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
            </main>
        @endif

    </div>
</div>

{{ $slot }}


@stack('modals')
@livewireScripts
@if(session('script'))
    {!! session('script') !!}
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="https://unpkg.com/@pqina/flip/dist/flip.min.js"></script>
<script>
    // JavaScript to hide the splash screen after a delay
    window.addEventListener('load', function() {
        setTimeout(function() {
            const splashScreen = document.getElementById('splash-screen');
            if (splashScreen) {
                splashScreen.style.display = 'none'; // Hide the splash screen
            }
        }, 2000); // Delay in milliseconds (e.g., 2000ms = 2 seconds)
    });
</script>

</body>

</html>
