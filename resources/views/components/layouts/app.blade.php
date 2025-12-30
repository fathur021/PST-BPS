<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/logo-pst.svg') }}">

    <title>{{ $title ?? 'PST BPS BUKITTINGGI' }}</title>

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous" defer></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

    <!-- Signature Pad -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js" defer></script>

    <!-- Application Assets -->
    {{-- <link href="{{ asset('build/assets/app-BTEZCi8y.css') }}" rel="stylesheet" />
    <link href="{{ asset('build/assets/theme-DGURe29u.css') }}" rel="stylesheet" />
    <script src="{{ asset('build/assets/app-LnOaokaA.js') }}" defer></script> --}}
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    @livewire('partials.navbar')

    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 800)" x-show="show"
        x-transition:enter="transition-opacity ease-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">
        @livewire('partials.footer')
    </div>

    {{-- @livewireScripts --}}
    @livewireScripts
</body>

</html>
