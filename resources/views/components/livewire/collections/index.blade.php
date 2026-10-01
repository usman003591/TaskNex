<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component {
    public $collections;
    public bool $isCreating = false;
    public string $collectionName = "";
    public ?int $activeId = null;

    public function mount()
    {
        // route parameter model ho ya plain id, dono cases handle ho jate hain
        $param = request()->route('collection');
        $this->activeId = (int) data_get($param, 'id', $param) ?: null;

        $this->loadCollections();
    }

    public function loadCollections(){
        $this->collections = auth()->user()->collections()->latest()->get();
    }

    public function createCollection()
    {
        $this->validate([
            "collectionName" => "required|string|max:255",
        ]);

        $collection = auth()->user()->collections()->create([
                "name" => trim($this->collectionName),
            ]);

        $this->loadCollections();
        $this->collectionName = "";
        $this->isCreating = false;
    }

    #[On("collection-renamed")]
    public function refreshCollection()
    {
        $this->loadCollections();
    }
};
?>

<div class="tn-sidebar__section flex flex-1 min-h-0 flex-col">
    <div class="tn-sidebar__label">
        <span x-transition.opacity.duration.150ms>Collections</span>
        <button type="button" class="tn-sidebar__add" aria-label="Create collection">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round">
                <path d="M12 5v14M5 12h14" />
            </svg>
        </button>
    </div>
    <div class="flex flex-1 min-h-0 flex-col">

        <!-- New Collection toggle: button <-> input -->
        <div x-data x-on:click.outside="$wire.set('isCreating', false)" class="px-0.5 mb-1">
            @if($isCreating == true)
            <input type="text" x-ref="collectionInput" x-init="$nextTick(() => $refs.collectionInput?.focus())"
                wire:model="collectionName" wire:keydown.enter="createCollection" placeholder="Collection name"
                class="w-full rounded-lg bg-gray-800 border border-white/10 px-2.5 py-2 text-sm text-white placeholder:text-gray-500 focus:outline-hidden focus:border-indigo-500" />
            @error('collectionName')
            <p class="text-xs text-red-400 mt-1 px-1">{{ $message }}</p>
            @enderror
            @else
            <button type="button" wire:click="$set('isCreating', true)"
                class="flex items-center gap-x-3.5 py-2 mt-2.5 px-2.5 w-full text-sm text-gray-300 rounded-lg hover:bg-white/5 hover:text-white focus:outline-hidden focus:bg-sidebar-nav-focus">
                <i class="fa-solid fa-plus text-xs"></i>
                <span x-transition.opacity.duration.150ms>New collection</span>
            </button>
            @endif
        </div>

        <!-- Created collections -->
        <div class="space-y-1 flex-1 min-h-0 overflow-y-auto custom-scrollbar -mx-1 px-1">
            @foreach($collections as $collection)
            @php($isActive = $activeId === $collection->id)

            <a href="{{ route('tasks.index', $collection->id) }}" class="tn-nav-link {{ $isActive ? 'active' : '' }}"
                @if ($isActive) data-active="true" @endif wire:navigate>
                <span class="tn-nav-link__icon">
                    <i class="fa-solid fa-arrows-to-dot"></i>
                </span>
                <span x-transition.opacity.duration.150ms class="truncate tn-nav-link__text">
                    {{ $collection->name }}
                </span>
            </a>
            @endforeach
        </div>
    </div>
</div>


