<?php
use Livewire\Volt\Component;

new class extends Component {};
?>


<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>🦍 MAKE TEXT STRONK 🦍</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(["resources/css/app.css", "resources/js/app.js"])
        @fluxStyles
    </head>

    <body class="min-h-screen bg-white dark dark:bg-zinc-800">
        {{ $slot }}
        @volt("layouts.main")
            @persist("toast")
                <flux:toast />
            @endpersist

            @fluxScripts()
        @endvolt
    </body>
</html>
