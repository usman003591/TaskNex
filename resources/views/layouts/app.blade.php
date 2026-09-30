<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name', 'TaskNex') }}</title>
    <link rel="icon" href="{{ asset('favicon-16.png') }}" type="image/png" sizes="16x16">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/air-datepicker@3/air-datepicker.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>

<body class="tn-shell min-h-screen antialiased" wire:navigate.hover>
    <div class="min-h-screen" x-data="{
        mobileOpen: false,

        closeMobile() {
            this.mobileOpen = false;
        }
    }">
        {{-- Mobile backdrop --}}
        <button type="button"
            class="fixed inset-0 z-20 hidden cursor-default border-0 bg-[#0b0c13]/70 backdrop-blur-sm md:hidden"
            :class="{ 'block!': mobileOpen }" aria-label="Close navigation" x-on:click="closeMobile()"></button>

        {{-- TaskNex sidebar --}}
        <livewire:livewire.app-sidebar />

        {{-- Main content --}}
        <div class="tn-main min-h-screen">
            <header class="tn-navbar">
                <div class="tn-navbar__leading">
                    <button type="button" class="tn-icon-button" aria-label="Open sidebar"
                        aria-controls="tasknex-sidebar" x-on:click="mobileOpen = true">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="tn-navbar__divider hidden sm:block"></div>

                    <button type="button" class="tn-search-trigger">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round">
                            <circle cx="11" cy="11" r="7" />
                            <path d="m20 20-4-4" />
                        </svg>
                        <span>Jump to anything</span>
                    </button>
                </div>

                <div class="tn-navbar__actions">
                    <button type="button" class="tn-icon-button" aria-label="Notifications">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4" />
                        </svg>
                    </button>
                    <div class="tn-navbar__divider hidden sm:block"></div>
                    <button type="button" class="tn-icon-button" aria-label="Notifications">
                        <i class="fa-regular fa-moon"></i>
                    </button>

                    {{-- <div class="tn-navbar__divider"></div> --}}

                    {{-- <button type="button" class="tn-share-button">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        <span>Share space</span>
                    </button> --}}
                </div>
            </header>

            <main class="px-5 pb-10 pt-8 sm:px-8 lg:px-12 lg:pt-12">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.4.0/air-datepicker.js"></script>
    @stack('scripts')
</body>

</html>
