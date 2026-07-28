<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-gray-900" wire:navigate.hover>
    <nav
        class="relative bg-gray-900 after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
        <div class="mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center">
                <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                    alt="Your Company" class="h-8 mr-3 w-auto" />
                <span class="text-white text-lg font-semibold">TaskNex</span>
            </div>
        </div>
    </nav>
    <div class="flex h-[calc(100vh-4rem)]">

        <!-- Sidebar -->
        <aside class="w-56 shrink-0 bg-gray-950/50 border-r border-white/10">
            <nav class="px-3 py-4 space-y-6">

                <div class="space-y-1 text-white/80">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-sidebar-nav-foreground rounded-lg hover:bg-white/5 hover:text-white focus:outline-hidden focus:bg-sidebar-nav-focus {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white'
                : 'text-gray-300 hover:bg-white/5 hover:text-white' }}" wire:navigate>
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('starred') }}" class="flex items-center gap-x-3.5 py-2 px-2.5 bg-sidebar-nav-active text-sm text-sidebar-nav-foreground rounded-lg hover:bg-white/5 hover:text-white focus:outline-hidden focus:bg-sidebar-nav-focus {{ request()->routeIs('starred') ? 'bg-white/10 text-white'
                : 'text-gray-300 hover:bg-white/5 hover:text-white' }}" wire:navigate>
                        <i class="fa-regular fa-star" width="24" height="24"></i>
                        Starred
                    </a>
                </div>


                    <livewire:lists />

            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="text-lg font-medium text-white">{{ $slot }}</div>
        </main>

    </div>


    @livewireScripts
</body>

</html>
