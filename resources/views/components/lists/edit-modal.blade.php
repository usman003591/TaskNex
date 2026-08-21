<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use App\Models\TaskList;


new class extends Component
{
    public Tasklist $list;
    public bool $open = false;
    #[Validate('required|string|max:255')]
    public string $name;

    public function mount(TaskList $list){
        $this->list = $list;
    }

    #[On('open-edit-list-modal')]
    public function openModal()
    {
        $this->name = $this->list->name;
        return $this->open = true;
    }

    public function closeModal()
    {
        $this->reset(['open', 'name']);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();
        $this->list->update(['name' => $this->name]);
        $this->dispatch('list-renamed');
        $this->closeModal();
    }
};
?>

<div>
    @if($open)
    <div x-data="{ show: false }" x-init="$nextTick(() => {
            show = true;
            requestAnimationFrame(() => requestAnimationFrame(() => $refs.nameInput.focus()))})"
        x-on:keydown.escape.window="show = false; setTimeout(() => $wire.closeModal(), 300)" class="flex inset-0 z-50">

        <div x-show="show" x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-on:click="show = false; setTimeout(() => $wire.closeModal(), 300)"
            class="absolute inset-0 bg-black/60 backdrop-blur-xs"></div>

        <div class="absolute inset-0 overflow-y-auto flex items-center justify-center p-4">
            <div x-show="show" x-transition:enter="transition-all ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
                class="relative w-full sm:max-w-md bg-gray-900 rounded-lg shadow-3xl overflow-hidden">

                <!-- Header -->
                <div class="flex items-center justify-between px-5 pt-5 pb-1">
                    <div class="flex items-center gap-2.5">
                        <div class="flex items-center justify-center size-7 rounded-lg bg-gray-500/15 text-gray-500">
                            <i class="fa-solid fa-edit text-xs"></i>
                        </div>
                        <h2 class="text-sm font-medium text-white">Rename list</h2>
                    </div>
                    <button type="button" x-on:click="show = false; setTimeout(() => $wire.closeModal(), 300)"
                        aria-label="Close"
                        class="flex size-7 items-center justify-center text-gray-500 cursor-pointer hover:text-gray-300 transition-colors">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>
                {{-- create form --}}
                <form wire:submit="save" class="px-5 pb-5 pt-3 space-y-3">

                    {{-- name field --}}
                    <div>
                        <input type="text" wire:model="name" x-ref="nameInput"
                            class="w-full bg-black/2 rounded-md border border-gray-500/10 px-3.5 py-3 text-sm font-normal text-gray-300 placeholder:text-gray-500 focus:outline-none focus:border-white/10 focus:ring-0 focus:ring-white-5 transition-shadow"
                            placeholder="New list">
                        @error('name')
                        <small class="text-xs font-normal text-red-400/90 mt-1 px-1 block">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="flex justify-end pt-3">
                        <button type="submit" class="pl-4 py-2 text-sm font-medium text-blue-500 hover:text-blue-400">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @endif
</div>
