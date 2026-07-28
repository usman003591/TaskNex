<?php

use Livewire\Component;
use App\Models\User;

new class extends Component
{
    public $lists;
    public $isCreating = false;
    public $listName = '';

    public function mount(){
        $this->lists = User::current()->lists()->latest()->get();
    }

    public function createList(){
        $this->validate([
            'listName' => 'required|string|min:1|max:255',
        ]);

        $list = User::current()->lists()->create([
            'name' => $this->listName,
        ]);

        $this->lists = User::current()->lists()->latest()->get();
        $this->listName = '';
        $this->isCreating = false;
    }
};
?>

<div>
    <div class="flex items-center justify-between px-3 mb-1 h-4">
        <div class="flex items-center gap-x-3.5 text-xs font-medium uppercase text-gray-500">
            <i class="fa-solid fa-list-ul"></i>
            <p class="mb-0.5">Lists</p>
        </div>
    </div>

    <!-- New list toggle: button <-> input -->
    <div x-data x-on:click.outside="$wire.set('isCreating', false)" class="px-0.5 mb-1">
        @if($isCreating == true)
            <input
                type="text"
                x-ref="listInput"
                x-init="$nextTick(() => $refs.listInput?.focus())"
                wire:model="listName"
                wire:keydown.enter="createList"
                placeholder="List name"
                class="w-full rounded-lg bg-gray-800 border border-white/10 px-2.5 py-2 text-sm text-white placeholder:text-gray-500 focus:outline-hidden focus:border-indigo-500"
            />
            @error('listName')
                <p class="text-xs text-red-400 mt-1 px-1">{{ $message }}</p>
            @enderror
        @else
            <button
                type="button"
                wire:click="$set('isCreating', true)"
                class="flex items-center gap-x-3.5 py-2 px-2.5 w-full text-sm text-gray-300 rounded-lg hover:bg-white/5 hover:text-white focus:outline-hidden focus:bg-sidebar-nav-focus"
            >
                <i class="fa-solid fa-plus text-xs"></i>
                New list
            </button>
        @endif
    </div>

    <!-- Created lists -->
    <div class="space-y-1">
        @foreach($lists as $list)
            <a href="#"
                wire:navigate
                class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg focus:outline-hidden focus:bg-sidebar-nav-focus transition-colors
                       {{ request()->route('list')?->id === $list->id
                            ? 'bg-white/10 text-white'
                            : 'text-gray-300 hover:bg-white/5 hover:text-white' }}"
            >
                {{ $list->name }}
            </a>
        @endforeach
    </div>
</div>
