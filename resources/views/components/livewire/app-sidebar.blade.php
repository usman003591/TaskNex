<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

new class extends Component
{
    #[On('logout-user')]
    public function logout()
    {
        Auth::guard('web')->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }
};
?>

<aside id="tasknex-sidebar" class="tn-sidebar" :class="{ 'open': mobileOpen }">
            <div class="tn-sidebar__header">
                <a href="{{ route('dashboard') }}" class="tn-brand" wire:navigate aria-label="TaskNex dashboard">
                    <img src="{{ asset('images/logo.png') }}" alt="TaskNex Logo" class="tn-brand__mark">
                    <span x-transition.opacity.duration.150ms>
                        tasknex<span class="text-accent">.</span>
                    </span>
                </a>

                <button type="button" class="tn-icon-button md:hidden" aria-label="Close sidebar"
                    x-on:click="closeMobile()">
                    {{-- <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"/>
                    </svg> --}}
                </button>

                {{-- <span class="tn-icon-button hidden md:grid" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m12 3 1.7 5.3L19 10l-5.3 1.7L12 17l-1.7-5.3L5 10l5.3-1.7L12 3Z"/>
                        <path d="m19 16 .7 2.3L22 19l-2.3.7L19 22l-.7-2.3L16 19l2.3-.7L19 16Z"/>
                    </svg>
                </span> --}}
            </div>

            <div class="tn-sidebar__section">
                <div class="tn-sidebar__label">
                    <span x-transition.opacity.duration.150ms>Workspace</span>
                </div>

                <nav class="tn-sidebar__nav" aria-label="Workspace">
                    <a href="{{ route('dashboard') }}"
                        class="tn-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        @if (request()->routeIs('dashboard')) data-active="true" @endif wire:navigate title="Dashboard">
                        <span class="tn-nav-link__icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <path d="M9 22V12h6v10" />
                            </svg>
                        </span>
                        <span class="tn-nav-link__text" x-transition.opacity.duration.150ms>Dashboard</span>
                    </a>

                    <a href="{{ route('starred') }}"
                        class="tn-nav-link {{ request()->routeIs('starred') ? 'active' : '' }}"
                        @if (request()->routeIs('starred')) data-active="true" @endif wire:navigate title="Starred">
                        <span class="tn-nav-link__icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-2.9-5.6 2.9 1.1-6.2L3 9.6l6.2-.9L12 3Z" />
                            </svg>
                        </span>
                        <span class="tn-nav-link__text" x-transition.opacity.duration.150ms>Starred</span>
                    </a>
                </nav>
            </div>

            <div class="tn-sidebar__section flex flex-1 min-h-0 flex-col">
                <div class="tn-sidebar__label">
                    <span x-transition.opacity.duration.150ms>Collections</span>
                    <button type="button" class="tn-sidebar__add" aria-label="Create collection">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                    </button>
                </div>

                <livewire:collections.index />
            </div>

            <div class="tn-sidebar__footer">
                {{-- <a href="{{ url('/settings') }}" class="tn-sidebar__footer-link" wire:navigate title="Settings">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                        <path
                            d="m19.4 15 .1.1a2 2 0 0 1-2.8 2.8l-.1-.1a2 2 0 0 0-3.4 1.4v.2a2 2 0 0 1-4 0v-.2a2 2 0 0 0-3.4-1.4l-.1.1A2 2 0 0 1 3 15.1l.1-.1a2 2 0 0 0-1.4-3.4h-.2a2 2 0 0 1 0-4h.2a2 2 0 0 0 1.4-3.4L3 4.1a2 2 0 0 1 2.8-2.8l.1.1a2 2 0 0 0 3.4-1.4v-.2a2 2 0 0 1 4 0V0a2 2 0 0 0 3.4 1.4l.1-.1A2 2 0 0 1 19.6 4l-.1.1a2 2 0 0 0 1.4 3.4h.2a2 2 0 0 1 0 4h-.2a2 2 0 0 0-1.5 3.5Z"
                            transform="translate(1 1) scale(.92)" />
                    </svg>
                    <span x-transition.opacity.duration.150ms>Settings</span>
                </a> --}}

                <div class="tn-profile">
                    <div class="tn-profile__avatar" aria-hidden="true">
                        {{ strtoupper(substr(auth()->user()->name ?? 'MC', 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1" x-transition.opacity.duration.150ms>
                        <div class="tn-profile__name">{{ auth()->user()->name ?? 'Maya Chen' }}</div>
                        <div class="tn-profile__meta">{{ auth()->user()->email ?? 'Personal Workspace' }}</div>
                    </div>
                    <div x-data="{ optionsDropdown: false }" class="relative">
                        <button type="button" class="tn-icon-button" aria-label="Open profile menu" x-on:click="optionsDropdown = !optionsDropdown" :aria-expanded="optionsDropdown">
                            <i class="fa-solid fa-ellipsis text-[14px]"></i>
                        </button>
                        <div x-show="optionsDropdown" x-on:click.outside="optionsDropdown = false"
                            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute left-0 bottom-11 z-10 min-w-52 overflow-hidden rounded-[0.85rem] border border-[#383a50] bg-[#222438]"
                            style="display: none">
                            <button type="button" wire:click="$dispatch('open-delete-collection-confirmation')"
                                x-on:click="optionsDropdown = false"
                                class="flex w-full items-center gap-2.5 px-3.5 py-[0.7rem] text-left text-xs text-[#c4c5ce] transition-colors duration-180 motion-reduce:transition-none hover:bg-[#303249] hover:text-green-300">
                                <i class="fa-solid fa-pen text-[11px]"></i>
                                Profile Settings
                            </button>
                            <button type="button" wire:click="logout" x-on:click="optionsDropdown = false"
                                class="flex w-full items-center gap-2.5 px-3.5 py-[0.7rem] text-left text-xs text-[#c4c5ce] transition-colors duration-180 motion-reduce:transition-none hover:bg-[#303249] hover:text-text-primary">
                                <i class="fa-solid fa-arrow-right-from-bracket text-[11px]"></i>
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
