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

                <div class="space-y-1">
                    <a href="#" class="block rounded-md bg-gray-800 px-3 py-2 text-sm font-medium text-white" wire:navigate>
                        Dashboard
                    </a>
                    <a href="#"
                        class="block rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white" wire:navigate>
                        Starred
                    </a>
                </div>

                <div>
                    <p class="px-3 mb-1 text-xs font-medium uppercase tracking-wide text-gray-500">Lists</p>
                    <div class="space-y-1">
                        <a href="#"
                            class="block rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white" wire:navigate>
                            Work
                        </a>
                        <a href="#"
                            class="block rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white" wire:navigate>
                            Personal
                        </a>
                    </div>
                </div>

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
