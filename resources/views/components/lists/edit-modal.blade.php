<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use App\Models\TaskList;

new class extends Component {
    public Tasklist $list;
    public bool $open = false;
    #[Validate("required|string|max:255")]
    public string $name;

    public function mount(TaskList $list)
    {
        $this->list = $list;
    }

    #[On("open-edit-list-modal")]
    public function openModal()
    {
        $this->name = $this->list->name;
        return $this->open = true;
    }

    public function closeModal()
    {
        $this->reset(["open", "name"]);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();
        $this->list->update(["name" => $this->name]);
        $this->dispatch("list-renamed");
        $this->closeModal();
    }
};
?>


<x-modal-frame :open="$open" title="Rename List" description="Edit the name of the collection." icon="fa-solid fa-edit text-xs">
    <form wire:submit="save" class="space-y-5 px-5 py-3 sm:px-6 sm:pb-6">

        {{-- name field --}}
        <div>
            <label for="list-name"
                class="block mb-2 ml-[0.15rem] text-[#85899f] text-[0.625rem] font-extrabold tracking-[0.16em] uppercase">List
                name</label>
            <input id="list-name" type="text" wire:model="name" x-ref="nameInput"
                class="font-thin w-full text-[#e0e0dd] bg-[#171925]/82 border border-[#3d4058] rounded-xl outline-none py-2 px-4 text-[0.8rem] placeholder:text-text-muted transition-colors duration-180 motion-reduce:transition-none focus:bg-[#171925] focus:border-[#3d4058] focus:outline-none focus:shadow-none focus:ring-0"
                placeholder="New list" autocomplete="off">
            @error('name')
            <small class="mt-1.5 block px-1 text-xs text-[#ff9b87]">{{ $message }}</small>
            @enderror
        </div>
        <div class="flex justify-end pt-2">
            <button type="submit"
                class="inline-flex min-h-8 items-center gap-2 py-2 px-4 text-surface-sidebar text-xs font-extrabold bg-accent rounded-xl shadow-[0_8px_22px_rgb(199_243_107/0.12)] transition-[background-color,transform,opacity] duration-180 motion-reduce:transition-none hover:bg-accent-hover hover:-translate-y-px cursor-pointer">
                Save
            </button>
        </div>
    </form>
</x-modal-frame>
