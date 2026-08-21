<?php

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;

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

    #[On('list-renamed')]
    public function refreshLists(){
        $this->mount();
    }
};
?>

<div>

    <!-- New list toggle: button <-> input -->
    <div x-data x-on:click.outside="$wire.set('isCreating', false)" class="px-0.5 mb-1 flex">
        @if($isCreating == true)
        <input type="text" x-ref="listInput" x-init="$nextTick(() => $refs.listInput?.focus())" wire:model="listName"
            wire:keydown.enter="createList" placeholder="List name"
            class="w-full rounded-lg bg-gray-800 border border-white/10 px-2.5 py-2 text-sm text-white placeholder:text-gray-500 focus:outline-hidden focus:border-indigo-500" />
        @error('listName')
        <p class="text-xs text-red-400 mt-1 px-1">{{ $message }}</p>
        @enderror
        @else
        <button type="button" wire:click="$set('isCreating', true)"
            class="flex items-center gap-x-3.5 py-2 mt-2.5 px-2.5 w-full text-sm text-gray-300 rounded-lg hover:bg-white/5 hover:text-white focus:outline-hidden focus:bg-sidebar-nav-focus">
            <i class="fa-solid fa-plus text-xs"></i>
            <span x-show="!collapsed" x-transition.opacity.duration.150ms>New list</span>
        </button>
        @endif
    </div>

    <!-- Created lists -->
    <div class="space-y-1">
        @foreach($lists as $list)
        <a href="{{ route('tasks.index', $list->id) }}" wire:navigate class="flex items-center gap-x-3.5 py-2 pl-3 px-2.5 text-sm rounded-lg focus:outline-hidden transition-colors
                       {{ request()->route('list')?->id === $list->id
                            ? 'bg-accent/15 text-white'
                            : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <span class="size-1.5 rounded-full bg-accent shrink-0"></span>
            <span x-show="!collapsed" x-transition.opacity.duration.150ms class="truncate">
                {{ $list->name }}</span>
        </a>
        @endforeach
    </div>
</div>
