<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/air-datepicker@3/air-datepicker.css">
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

    <div class="flex h-[calc(100vh-4rem)]"
        x-data="{
            collapsed: localStorage.getItem('sidebar-collapsed') === 'true',
            toggle() {
                this.collapsed = !this.collapsed;
                localStorage.setItem('sidebar-collapsed', this.collapsed);
            }
        }">

        <!-- Sidebar -->
        <aside
            class="shrink-0 bg-gray-950/50 border-r border-white/10 transition-all duration-200 overflow-hidden"
            :class="collapsed ? 'w-16' : 'w-56'">

            <nav class="px-3 py-4 space-y-6 h-full flex flex-col">

                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg focus:outline-hidden transition-colors
                               {{ request()->routeIs('dashboard')
                                    ? 'bg-accent/15 text-white'
                                    : 'text-gray-400 hover:bg-white/5 hover:text-white' }}"
                        wire:navigate>
                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        <span x-show="!collapsed" x-transition.opacity.duration.150ms>Dashboard</span>
                    </a>
                    <a href="{{ route('starred') }}"
                        class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg focus:outline-hidden transition-colors
                               {{ request()->routeIs('starred')
                                    ? 'bg-accent/15 text-white'
                                    : 'text-gray-400 hover:bg-white/5 hover:text-white' }}"
                        wire:navigate>
                        <i class="fa-regular fa-star text-sm w-4 text-center shrink-0"></i>
                        <span x-show="!collapsed" x-transition.opacity.duration.150ms>Starred</span>
                    </a>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <p x-show="!collapsed"
                       x-transition.opacity.duration.150ms
                       class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-gray-600">
                        Lists
                    </p>
                    <livewire:lists />

                </div>

                <!-- Collapse toggle -->
                <button
                    type="button"
                    x-on:click="toggle()"
                    class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg text-gray-500 hover:bg-white/5 hover:text-white transition-colors">
                    <svg class="size-4 shrink-0 transition-transform" :class="collapsed && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg>
                    <span x-show="!collapsed" x-transition.opacity.duration.150ms>Collapse</span>
                </button>

            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="text-lg font-medium text-white">{{ $slot }}</div>
        </main>

    </div>


    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.4.0/air-datepicker.js"></script>
</body>

</html>
