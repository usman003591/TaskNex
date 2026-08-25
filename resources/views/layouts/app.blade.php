<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name', 'TaskNex') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/air-datepicker@3/air-datepicker.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>

<body class="tn-shell min-h-screen antialiased" wire:navigate.hover>
    <div
        class="min-h-screen"
        x-data="{
            collapsed: localStorage.getItem('sidebar-collapsed') === 'true',
            mobileOpen: false,
            toggle() {
                this.collapsed = !this.collapsed;
                localStorage.setItem('sidebar-collapsed', this.collapsed);
            },
            closeMobile() {
                this.mobileOpen = false;
            }
        }"
        :style="{ '--tn-sidebar-width': collapsed ? '76px' : '280px' }"
    >
        {{-- Mobile backdrop --}}
        <button
            type="button"
            class="fixed inset-0 z-20 hidden cursor-default border-0 bg-[#0b0c13]/70 backdrop-blur-sm md:hidden"
            :class="{ '!block': mobileOpen }"
            aria-label="Close navigation"
            x-on:click="closeMobile()"
        ></button>

        {{-- TaskNex sidebar --}}
        <aside
            id="tasknex-sidebar"
            class="tn-sidebar"
            :class="{ 'open': mobileOpen }"
        >
            <div class="tn-sidebar__header">
                <a
                    href="{{ route('dashboard') }}"
                    class="tn-brand"
                    wire:navigate
                    aria-label="TaskNex dashboard"
                >
                    <span class="tn-brand__mark" aria-hidden="true">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3v18M3 12h18"/>
                        </svg>
                    </span>
                    <span x-show="!collapsed" x-transition.opacity.duration.150ms>
                        tasknex<span class="text-[#c7f36b]">.</span>
                    </span>
                </a>

                <button
                    type="button"
                    class="tn-icon-button md:hidden"
                    aria-label="Close sidebar"
                    x-on:click="closeMobile()"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                </button>

                <span class="tn-icon-button hidden md:grid" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m12 3 1.7 5.3L19 10l-5.3 1.7L12 17l-1.7-5.3L5 10l5.3-1.7L12 3Z"/>
                        <path d="m19 16 .7 2.3L22 19l-2.3.7L19 22l-.7-2.3L16 19l2.3-.7L19 16Z"/>
                    </svg>
                </span>
            </div>

            <div class="tn-sidebar__section">
                <div class="tn-sidebar__label">
                    <span x-show="!collapsed" x-transition.opacity.duration.150ms>Workspace</span>
                </div>

                <nav class="tn-sidebar__nav" aria-label="Workspace">
                    <a
                        href="{{ route('dashboard') }}"
                        class="tn-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        @if(request()->routeIs('dashboard')) data-active="true" @endif
                        wire:navigate
                        title="Dashboard"
                    >
                        <span class="tn-nav-link__icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <path d="M9 22V12h6v10"/>
                            </svg>
                        </span>
                        <span class="tn-nav-link__text" x-show="!collapsed" x-transition.opacity.duration.150ms>Dashboard</span>
                    </a>

                    <a
                        href="{{ route('starred') }}"
                        class="tn-nav-link {{ request()->routeIs('starred') ? 'active' : '' }}"
                        @if(request()->routeIs('starred')) data-active="true" @endif
                        wire:navigate
                        title="Starred"
                    >
                        <span class="tn-nav-link__icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-2.9-5.6 2.9 1.1-6.2L3 9.6l6.2-.9L12 3Z"/>
                            </svg>
                        </span>
                        <span class="tn-nav-link__text" x-show="!collapsed" x-transition.opacity.duration.150ms>Starred</span>
                    </a>
                </nav>
            </div>

            <div class="tn-sidebar__section flex-1 overflow-y-auto">
                <div class="tn-sidebar__label">
                    <span x-show="!collapsed" x-transition.opacity.duration.150ms>Lists</span>
                    <button
                        type="button"
                        class="tn-sidebar__add"
                        x-show="!collapsed"
                        aria-label="Create list"
                    >
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                    </button>
                </div>

                <livewire:lists />
            </div>

            <div class="tn-sidebar__footer">
                <a href="{{ url('/settings') }}" class="tn-sidebar__footer-link" wire:navigate title="Settings">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z"/>
                        <path d="m19.4 15 .1.1a2 2 0 0 1-2.8 2.8l-.1-.1a2 2 0 0 0-3.4 1.4v.2a2 2 0 0 1-4 0v-.2a2 2 0 0 0-3.4-1.4l-.1.1A2 2 0 0 1 3 15.1l.1-.1a2 2 0 0 0-1.4-3.4h-.2a2 2 0 0 1 0-4h.2a2 2 0 0 0 1.4-3.4L3 4.1a2 2 0 0 1 2.8-2.8l.1.1a2 2 0 0 0 3.4-1.4v-.2a2 2 0 0 1 4 0V0a2 2 0 0 0 3.4 1.4l.1-.1A2 2 0 0 1 19.6 4l-.1.1a2 2 0 0 0 1.4 3.4h.2a2 2 0 0 1 0 4h-.2a2 2 0 0 0-1.5 3.5Z" transform="translate(1 1) scale(.92)"/>
                    </svg>
                    <span x-show="!collapsed" x-transition.opacity.duration.150ms>Settings</span>
                </a>

                <button
                    type="button"
                    class="tn-sidebar__footer-link"
                    x-on:click="toggle()"
                    :aria-label="collapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                >
                    <svg
                        width="17"
                        height="17"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="transition-transform duration-200"
                        :class="{ 'rotate-180': collapsed }"
                    >
                        <path d="m11 17-5-5 5-5M18 17l-5-5 5-5"/>
                    </svg>
                    <span x-show="!collapsed" x-transition.opacity.duration.150ms>Collapse</span>
                </button>

                <div class="tn-profile">
                    <div class="tn-profile__avatar" aria-hidden="true">
                        {{ strtoupper(substr(auth()->user()->name ?? 'MC', 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1" x-show="!collapsed" x-transition.opacity.duration.150ms>
                        <div class="tn-profile__name">{{ auth()->user()->name ?? 'Maya Chen' }}</div>
                        <div class="tn-profile__meta">Personal workspace</div>
                    </div>
                    <button type="button" class="tn-icon-button" aria-label="Open profile menu" x-show="!collapsed">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <circle cx="5" cy="12" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/>
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="tn-main min-h-screen">
            <header class="tn-navbar">
                <div class="tn-navbar__leading">
                    <button
                        type="button"
                        class="tn-icon-button"
                        aria-label="Open sidebar"
                        aria-controls="tasknex-sidebar"
                        x-on:click="mobileOpen = true"
                    >
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                            <path d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div class="tn-navbar__divider hidden sm:block"></div>

                    <button type="button" class="tn-search-trigger">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
                        </svg>
                        <span>Jump to anything</span>
                        <kbd>⌘ K</kbd>
                    </button>
                </div>

                <div class="tn-navbar__actions">
                    <button type="button" class="tn-icon-button" aria-label="Notifications">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/>
                        </svg>
                    </button>

                    <div class="tn-navbar__divider"></div>

                    <button type="button" class="tn-share-button">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        <span>Share space</span>
                    </button>
                </div>
            </header>

            <main class="px-5 pb-20 pt-8 sm:px-8 lg:px-12 lg:pt-12">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.4.0/air-datepicker.js"></script>
    @stack('scripts')
</body>

</html>
