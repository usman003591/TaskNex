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

            <livewire:collections.index />

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
                    <x-dropdown align="right" position="top">
                        <x-slot:trigger>
                            <button type="button" class="tn-icon-button" aria-label="Open profile menu">
                                <i class="fa-solid fa-ellipsis text-[14px]"></i>
                            </button>
                        </x-slot:trigger>

                        <x-dropdown-item icon="fa-solid fa-pen" hover-color="hover:text-green-300"
                            wire:click="$dispatch('open-delete-collection-confirmation')">
                            Profile Settings
                        </x-dropdown-item>
                        <x-dropdown-item icon="fa-solid fa-arrow-right-from-bracket"
                            wire:click="logout">
                            Logout
                        </x-dropdown-item>
                    </x-dropdown>
                </div>
            </div>
        </aside>
