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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-barlow antialiased bg-[#F7F7F9]">

<div class="min-h-screen max-w-screen-2xl mx-auto bg-[#F7F7F9] {{ $mainClass }}">
    @if (isset($sidebar))
        {{-- Sidebar --}}
        <sidebar class="h-screen w-[280px] flex flex-col shadow bg-white z-10 ">
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
            <main class="relative flex-1 max-lg:h-dvh lg:overflow-y-auto  w-full px-6 pt-2">
                {{ $main }}
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

</body>

</html>
