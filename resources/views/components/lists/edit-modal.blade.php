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

<div>
    @if($open)
    <div x-data="{ show: false }" x-init="$nextTick(() => {
            show = true;
            requestAnimationFrame(() => requestAnimationFrame(() => $refs.nameInput.focus()))})"
        x-on:keydown.escape.window="show = false; setTimeout(() => $wire.closeModal(), 300)"
        class="fixed inset-0 z-50 font-['DM_Sans',_ui-sans-serif,_system-ui,_sans-serif]">

        <div x-show="show" x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-on:click="show = false; setTimeout(() => $wire.closeModal(), 300)"
            class="absolute inset-0 bg-black/60 backdrop-blur-md" aria-hidden="true"></div>

        <div class="absolute inset-0 flex items-center justify-center overflow-y-auto p-4 sm:p-6">
            <div x-show="show" x-transition:enter="transition-all ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 scale-[.98]" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition-all ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 -translate-y-4 scale-[.98]"
                class="relative my-auto w-full max-w-lg overflow-visible bg-[#1c1d2b] border border-[#454860] rounded-xl" role="dialog" aria-modal="true" aria-labelledby="edit-list-name">

                <!-- Header -->
                <div class="px-5 pb-7 pt-5 sm:px-6 sm:pt-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div
                                class="grid mt-1 h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#c7f36b]/10 text-[#c7f36b]">
                                <i class="fa-solid fa-edit text-xs"></i>
                            </div>
                            <div>
                                <h2 id="create-task-title"
                                    class="text-xl font-semibold text-[#f5f4ef] font-['Space_Grotesk',_ui-sans-serif,_system-ui,_sans-serif] tracking-[-0.04em]">
                                    Rename List
                                </h2>
                                <p class="mt-1 text-[11px] text-[#85899f]">
                                    Edit the name of the collection
                                </p>
                            </div>
                        </div>

                        <button type="button" x-on:click="show = false; setTimeout(() => $wire.closeModal(), 300)"
                            aria-label="Close create task dialog" class="tn-icon-button cursor-pointer">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>
                </div>


                {{-- create form --}}
                <form wire:submit="save" class="space-y-5 px-5 pb-5 sm:px-6 sm:pb-6">

                    {{-- name field --}}
                    <div>
                        <label for="list-name"
                            class="block mb-2 ml-[0.15rem] text-[#85899f] text-[0.625rem] font-extrabold tracking-[0.16em] uppercase">List
                            name</label>
                        <input id="list-name" type="text" wire:model="name" x-ref="nameInput"
                            class="font-thin w-full text-[#e0e0dd] bg-[#171925]/[0.82] border border-[#3d4058] rounded-xl outline-none py-2 px-4 text-[0.8rem] placeholder:text-[#666b85] transition-colors duration-[180ms] motion-reduce:transition-none focus:bg-[#171925] focus:border-[#3d4058] focus:outline-none focus:shadow-none focus:ring-0"
                            placeholder="New list" autocomplete="off">
                        @error('name')
                        <small class="mt-1.5 block px-1 text-xs text-[#ff9b87]">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="flex justify-end pt-3">
                        <button type="submit" class="inline-flex min-h-8 items-center gap-2 py-2 px-4 text-[#171825] text-xs font-extrabold bg-[#c7f36b] rounded-xl shadow-[0_8px_22px_rgb(199_243_107_/_0.12)] transition-[background-color,transform,opacity] duration-[180ms] motion-reduce:transition-none hover:bg-[#d6fa87] hover:-translate-y-px cursor-pointer">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @endif
</div>
