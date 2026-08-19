<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Computed;
use App\Models\TaskList;
use Carbon\Carbon;

new class extends Component
{
    public TaskList $list;
    public bool $starred = false;
    public bool $open = false;

    #[Validate('required|string|max:255')]
    public string $name;
    #[Validate('nullable|string|max:255')]
    public string $details;
    #[Validate('nullable|date')]
    public ?string $scheduled_at = null;
    #[Validate('nullable|date')]
    public ?string $due_at = null;
    #[Validate('nullable|integer|in:1,2,3')]
    public ?int $priority = null;

    #[Computed]
    public function priorityMeta(): array
    {
        return [
                1 => ['label' => 'Urgent', 'color' => 'text-red-400'],
                2 => ['label' => 'Medium', 'color' => 'text-amber-400'],
                3 => ['label' => 'Low', 'color' => 'text-emerald-400']
            ];
    }

    public function openModal()
    {
        $this->open = true;
    }

    public function formattedDateTime(?string $dateTime): ?string
    {
        if (!$dateTime) {
            return null;
        }

        return Carbon::parse($dateTime)->format('D j M Y, g:i A');
    }

    #[Computed]
    public function formattedScheduledAt(): ?string
    {
        return $this->formattedDateTime($this->scheduled_at);
    }

    #[Computed]
    public function formattedDueAt(): ?string
    {
        return $this->formattedDateTime($this->due_at);
    }

    public function clearScheduledDate(): void
    {
        $this->scheduled_at = null;
    }

    public function clearDueDate(): void
    {
        $this->due_at = null;
    }

    public function closeModal(){
        $this->reset(['open', 'name', 'details', 'scheduled_at', 'due_at', 'priority', 'starred']);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $this->list->tasks()->create([
            'name' => $this->name,
            'details' => $this->details ?? null,
            'scheduled_at' => $this->scheduled_at ?? null,
            'due_at' => $this->due_at ?? null,
            'priority' => $this->priority ?? null,
            'starred' => $this->starred ?? null,
        ]);

        $this->dispatch('task-created');
        $this->closeModal();
    }
};
?>

<div>
    <!-- Modal -->
        @if($open)
        <div x-data="{ show: false, taskName: '' }" x-init="$nextTick(() => {
            show = true;
            requestAnimationFrame(() => requestAnimationFrame(() => $refs.nameInput.focus()))})"
            x-on:keydown.escape.window="show = false; setTimeout(() => $wire.closeModal(), 300)"
            class="flex inset-0 z-50">

            <div x-show="show" x-transition:enter="transition-opacity ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" x-on:click="show = false; setTimeout(() => $wire.closeModal(), 300)"
                class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

            <div class="absolute inset-0 overflow-y-auto flex items-center justify-center p-4">
                <div x-show="show" x-transition:enter="transition-all ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition-all ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4"
                    class="relative w-full sm:max-w-md bg-gray-900 border border-white/10 rounded-lg shadow-2xl overflow-hidden">

                    <!-- Header -->
                    <div class="flex items-center justify-between px-5 pt-5 pb-1">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="flex items-center justify-center size-7 rounded-lg bg-gray-500/15 text-gray-500">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </div>
                            <h2 class="text-sm font-medium text-white">New task</h2>
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
                                x-on:input="taskName = $event.target.value"
                                class="w-full bg-transparent rounded-md border border-white/10 px-3.5 py-3 text-sm font-normal text-gray-300 placeholder:text-gray-500 focus:outline-none focus:border-gray-600 focus:ring-0 focus:ring-gray-500/20 transition-shadow"
                                placeholder="New task">
                            @error('name')
                            <small class="text-xs font-normal text-red-400/90 mt-1 px-1 block">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- details field --}}
                        <div>
                            <textarea wire:model="details" rows="2" placeholder="Add details (optional)"
                                class="w-full bg-transparent rounded-md border border-white/10 px-3.5 py-3 text-sm font-normal text-gray-300 placeholder:text-gray-500 focus:outline-none focus:border-gray-600 focus:ring-0 focus:ring-gray-500/20 transition-shadow"></textarea>
                        </div>

                        {{-- priority field --}}
                        <div x-data="{priorityDropdownOpen: false}" class="relative inline-block">

                            <button type="button" x-on:click.prevent="priorityDropdownOpen = !priorityDropdownOpen"
                                class="inline-flex items-center justify-between w-36 gap-2 text-xs font-normal px-3 py-1.5 rounded-lg bg-transparent border border-white/10 cursor-pointer focus:outline-none focus:border-gray-600 focus:ring-0 focus:ring-gray-500/20 hover:outline-none hover:border-gray-600 hover:ring-0 hover:ring-gray-500/20">
                                <span class="flex items-center gap-2">
                                    <i class="fa-regular fa-flag text-[14px] {{ $priority ? $this->priorityMeta[
                                        $priority]['color'] : 'text-blue-500' }}"></i>
                                    <p class="{{ $priority ? $this->priorityMeta[
                                        $priority]['color'] : 'text-gray-500' }}">{{ $priority ? $this->priorityMeta[
                                        $priority]['label'] : 'Select priority' }}</p>
                                </span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-gray-500 transition-colors shrink-0"
                                    :class="priorityDropdownOpen && 'rotate-180'"></i>
                            </button>

                            <div x-show="priorityDropdownOpen" x-on:click.outside="priorityDropdownOpen = false"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute z-10 mt-1.5 bg-gray-900 border border-white/10 rounded-lg w-35 shadow-xl overflow-hidden"
                                style="display: none">

                                {{-- @if($priority) --}}
                                <button type="button" wire:click="$set('priority', null)"
                                    x-on:click="priorityDropdownOpen = false"
                                    class="flex items-center gap-2 w-full px-3 py-2 text-xs text-gray-500 hover:bg-white/5 border-white/10 transition-colors cursor-pointer">
                                    {{-- <i class="fa-solid fa-xmark text-[10px]"></i> --}}
                                    Select Priority
                                </button>
                                {{-- @endif --}}
                                @foreach ($this->priorityMeta as $key => $value)
                                <button type="button" wire:click="$set('priority', {{ $key }})"
                                    x-on:click="priorityDropdownOpen = false"
                                    class="flex items-center text-xs font-normal {{ $value['color'] }} gap-2 w-full py-1.5 px-3 hover:bg-white/5 transition-colors cursor-pointer">
                                    {{ $value['label'] }}
                                </button>
                                @endforeach

                            </div>
                        </div>

                        {{-- schedule date field --}}
                        <div x-data="datepickerComponent('scheduledDate', 'scheduled_at')" x-init="initDatepicker()">
                            @if(!$scheduled_at)
                            <button type="button" x-on:click.prevent="datepicker.show()"
                                class="inline-flex items-center gap-2 text-xs font-normal px-3 py-1.5 rounded-lg bg-transparent border border-white/10 cursor-pointer focus:outline-none focus:border-gray-600 focus:ring-0 focus:ring-gray-500/20 hover:outline-none hover:border-gray-600 hover:ring-0 hover:ring-gray-500/20">
                                <i class="fa-regular fa-clock text-[14px] text-blue-500"></i>
                                <p class="text-gray-500">Add Schedule date/time</p>
                            </button>
                            @else
                            <span
                                class="inline-flex items-center gap-2 text-xs font-normal px-3 py-1.5 rounded-lg bg-transparent border border-white/10 text-gray-300 hover:outline-none hover:border-gray-600 hover:ring-0 hover:ring-gray-500/20">
                                <i class="fa-regular fa-clock text-[14px] text-blue-500 cursor-pointer"
                                    x-on:click.prevent="datepicker.show()"></i>
                                {{ $this->formattedScheduledAt }}
                                <button type="button" wire:click="clearScheduledDate"
                                    class="text-gray-500 hover:text-gray-300 transition-colors cursor-pointer">
                                    <i class="fa-solid fa-xmark text-[10px]"></i>
                                </button>
                            </span>
                            @endif
                        </div>
                        <input type="text" id="scheduledDate" hidden wire:model="scheduled_at">

                        {{-- due date field --}}
                        <div x-data="datepickerComponent('dueDate', 'due_at')" x-init="initDatepicker()">
                            @if(!$due_at)
                            <button type="button" x-on:click.prevent="datepicker.show()"
                                class="inline-flex items-center gap-2 text-xs font-normal px-3 py-1.5 rounded-lg bg-transparent border border-white/10 cursor-pointer focus:outline-none focus:border-gray-600 focus:ring-0 focus:ring-gray-500/20 hover:outline-none hover:border-gray-600 hover:ring-0 hover:ring-gray-500/20">
                                <i class="fa-regular fa-calendar-check text-[14px] text-blue-500"></i>
                                <p class="text-gray-500">Add deadline</p>
                            </button>
                            @else
                            <span
                                class="inline-flex items-center gap-2 text-xs font-normal px-3 py-1.5 rounded-lg bg-transparent border border-white/10 text-gray-300 hover:outline-none hover:border-gray-600 hover:ring-0 hover:ring-gray-500/20">
                                <i class="fa-regular fa-clock text-[14px] text-blue-500 cursor-pointer"
                                    x-on:click.prevent="datepicker.show()"></i>
                                {{ $this->formattedDueAt }}
                                <button type="button" wire:click="clearDueDate"
                                    class="text-gray-500 hover:text-gray-300 transition-colors cursor-pointer">
                                    <i class="fa-solid fa-xmark text-[10px]"></i>
                                </button>
                            </span>
                            @endif
                        </div>
                        <input type="text" id="dueDate" hidden wire:model="due_at">

                        <div class="flex items-center justify-between pt-2 mt-1 pt-3">
                            <div class="ps-1 flex gap-4 text-gray-400 ">
                                <button type="button" wire:click.stop="$toggle('starred')"
                                    wire:loading.class="animate-pulse"
                                    class="shrink-0 cursor-pointer transition-transform duration-200 hover:scale-110 active:scale-125">
                                    @if($starred)
                                    <i
                                        class="fa-solid fa-star text-base text-yellow-500 transition-all duration-300 ease-out scale-110"></i>
                                    @else
                                    <i
                                        class="fa-regular fa-star text-base flex items-center justify-center text-yellow-500 transition-all duration-300 ease-out scale-100"></i>
                                    @endif
                                </button>

                            </div>
                            <button type="submit" x-bind:disabled="!taskName.trim()" :class="taskName.trim()
                                        ? 'text-blue-500 hover:text-blue-400 cursor-pointer'
                                        : 'text-gray-600'"
                                class="rounded-lg px-4 py-2 text-sm font-medium transition-colors">
                                Save
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        @endif
    <button type="button" wire:click="openModal" aria-label="New task" title="Add new task"
        class="fixed bottom-6 right-6 z-50 flex items-center justify-center size-13 rounded-full bg-blue-500 text-white hover:bg-blue-400 hover:scale-105 active:scale-95 transition-all duration-150">
        <i class="fa-solid fa-plus text-lg"></i>
    </button>
</div>
