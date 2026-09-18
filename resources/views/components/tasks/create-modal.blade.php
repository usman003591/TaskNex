<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\TaskList;
use Carbon\Carbon;

new class extends Component {
    public TaskList $list;
    public bool $starred = false;
    public bool $open = false;

    #[Validate("required|string|max:255")]
    public string $name;
    #[Validate("nullable|string|max:255")]
    public string $details;
    #[Validate("nullable|date")]
    public ?string $scheduled_at = null;
    #[Validate("nullable|date")]
    public ?string $due_at = null;
    #[Validate("nullable|integer|in:1,2,3")]
    public ?int $priority = null;

    #[Computed]
    public function priorityMeta(): array
    {
        return [
            1 => ["label" => "Urgent", "color" => "text-red-400"],
            2 => ["label" => "Medium", "color" => "text-amber-400"],
            3 => ["label" => "Low", "color" => "text-emerald-400"],
        ];
    }

    #[On("open-create-task-modal")]
    public function openModal()
    {
        $this->open = true;
    }

    public function formattedDateTime(?string $dateTime): ?string
    {
        if (!$dateTime) {
            return null;
        }

        return Carbon::parse($dateTime)->format("D j M Y, g:i A");
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

    public function closeModal()
    {
        $this->reset([
            "open",
            "name",
            "details",
            "scheduled_at",
            "due_at",
            "priority",
            "starred",
        ]);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $this->list->tasks()->create([
            "name" => $this->name,
            "details" => $this->details ?? null,
            "scheduled_at" => $this->scheduled_at ?? null,
            "due_at" => $this->due_at ?? null,
            "priority" => $this->priority ?? null,
            "starred" => $this->starred ?? null,
        ]);

        $this->dispatch("task-created");
        $this->closeModal();
    }
};
?>

<x-modal-frame :open="$open" title="New task" description="Add the next thing worth making room for." icon="fa-solid fa-plus">
    <form wire:submit="save" x-data="{ taskName: ''}" class="space-y-5 px-5 pb-5 sm:px-6 sm:pb-6">
        {{-- Name --}}
        <div>
            <label for="task-name"
                class="block mb-2 ml-[0.15rem] text-[#85899f] text-[0.625rem] font-extrabold tracking-[0.16em] uppercase">Task
                name</label>
            <input id="task-name" type="text" wire:model="name" x-ref="nameInput"
                x-on:input="taskName = $event.target.value"
                class="font-semibold w-full text-[#e0e0dd] bg-[#171925]/82 border border-[#3d4058] rounded-xl outline-none py-2 px-4 text-[0.8rem] placeholder:text-text-muted transition-colors duration-180 motion-reduce:transition-none focus:bg-[#171925] focus:border-[#3d4058] focus:outline-none focus:shadow-none focus:ring-0"
                placeholder="What's new on your mind?" autocomplete="off">
            @error('name')
            <small class="mt-1.5 block px-1 text-xs text-[#ff9b87]">{{ $message }}</small>
            @enderror
        </div>

        {{-- Details --}}
        <div>
            <label for="task-details"
                class="block mb-2 ml-[0.15rem] text-[#85899f] text-[0.625rem] font-extrabold tracking-[0.16em] uppercase">Description
                <span class="font-normal normal-case tracking-normal text-text-muted">(optional)</span></label>
            <textarea id="task-details" wire:model="details" rows="2"
                class="custom-scrollbar w-full text-[#e0e0dd] bg-[#171925]/82 border border-[#3d4058] rounded-xl outline-none min-h-20 resize-none py-[0.85rem] px-4 text-[0.8rem] leading-normal placeholder:text-text-muted transition-colors duration-180 motion-reduce:transition-none focus:bg-[#171925] focus:border-[#3d4058] focus:outline-none focus:shadow-none focus:ring-0"
                placeholder="Add a little context so future-you knows where to begin."></textarea>
        </div>

        {{-- Task options --}}
        <div>
            <div
                class="block mb-2 ml-[0.15rem] text-[#85899f] text-[0.625rem] font-extrabold tracking-[0.16em] uppercase">
                Task options</div>
            <div class="flex flex-wrap gap-2">
                {{-- Priority --}}
                <div x-data="{ priorityDropdownOpen: false }" class="relative">
                    <button type="button" x-on:click.prevent="priorityDropdownOpen = !priorityDropdownOpen"
                        class="inline-flex min-h-8 items-center gap-2 py-1 px-3 text-[#85899f] text-[0.7rem] font-semibold bg-[#171925]/62 border border-[#3d4058] rounded-[0.7rem] transition-colors duration-180 motion-reduce:transition-none hover:text-[#e0e0dd] hover:bg-[#222438] hover:border-[#565a76] cursor-pointer {{ $priority ? 'tn-create-modal__chip--active' : '' }}"
                        :aria-expanded="priorityDropdownOpen">
                        <i
                            class="fa-regular fa-flag text-[13px] {{ $priority ? $this->priorityMeta[$priority]['color'] : 'text-[#81c7ff]' }}"></i>
                        <span>{{ $priority ? $this->priorityMeta[$priority]['label'] : 'Priority' }}</span>
                        <i class="fa-solid fa-chevron-down ml-1 text-[9px] text-text-muted transition-transform"
                            :class="{ 'rotate-180': priorityDropdownOpen }"></i>
                    </button>

                    <div x-show="priorityDropdownOpen" x-on:click.outside="priorityDropdownOpen = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute left-0 top-11 z-30 min-w-36 overflow-hidden rounded-xl border border-[#383a50] bg-[#222438] py-1.5 shadow-2xl"
                        style="display: none">
                        <button type="button" wire:click="$set('priority', null)"
                            x-on:click="priorityDropdownOpen = false"
                            class="flex w-full items-center gap-2.5 px-3.5 py-[0.6rem] text-xs transition-colors duration-180 motion-reduce:transition-none hover:bg-[#303249] cursor-pointer">
                            <i class="fa-regular fa-flag text-[11px] text-text-muted"></i>
                            No priority
                        </button>
                        @foreach ($this->priorityMeta as $key => $value)
                        <button type="button" wire:click="$set('priority', {{ $key }})"
                            x-on:click="priorityDropdownOpen = false"
                            class="flex w-full items-center gap-2.5 px-3.5 py-[0.6rem] text-xs transition-colors duration-180 motion-reduce:transition-none hover:bg-[#303249] {{ $value['color'] }} cursor-pointer">
                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                            {{ $value['label'] }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Schedule date --}}
                <div x-data="datepickerComponent('scheduledDate', 'scheduled_at')" x-init="initDatepicker()">
                    @if(!$scheduled_at)
                    <button type="button" x-on:click.prevent="datepicker.show()"
                        class="inline-flex min-h-8 items-center gap-2 py-1 px-3 text-[#85899f] text-[0.7rem] font-semibold bg-[#171925]/62 border border-[#3d4058] rounded-[0.7rem] transition-colors duration-180 motion-reduce:transition-none hover:text-[#e0e0dd] hover:bg-[#222438] hover:border-[#565a76] cursor-pointer">
                        <i class="fa-regular fa-clock text-[13px] text-[#81c7ff]"></i>
                        <span>Schedule</span>
                    </button>
                    @else
                    <span
                        class="inline-flex min-h-8 items-center gap-2 py-1 px-3 text-[0.7rem] font-semibold bg-[#171925]/62 border border-[#3d4058] rounded-[0.7rem] tn-create-modal__chip--active">
                        <i class="fa-regular fa-clock cursor-pointer text-[13px] text-[#81c7ff]"
                            x-on:click.prevent="datepicker.show()"></i>
                        <span>{{ $this->formattedScheduledAt }}</span>
                        <button type="button" wire:click="clearScheduledDate"
                            class="ml-1 text-text-muted transition hover:text-text-primary" aria-label="Clear schedule">
                            <i class="fa-solid fa-xmark text-[10px]"></i>
                        </button>
                    </span>
                    @endif
                </div>
                <input type="text" id="scheduledDate" hidden wire:model="scheduled_at">

                {{-- Due date --}}
                <div x-data="datepickerComponent('dueDate', 'due_at')" x-init="initDatepicker()">
                    @if(!$due_at)
                    <button type="button" x-on:click.prevent="datepicker.show()"
                        class="inline-flex min-h-8 items-center gap-2 py-1 px-3 text-[#85899f] text-[0.7rem] font-semibold bg-[#171925]/62 border border-[#3d4058] rounded-[0.7rem] transition-colors duration-180 motion-reduce:transition-none hover:text-[#e0e0dd] hover:bg-[#222438] hover:border-[#565a76] cursor-pointer">
                        <i class="fa-regular fa-calendar-days text-[13px] text-[#ff896f]"></i>
                        <span>Deadline</span>
                    </button>
                    @else
                    <span
                        class="inline-flex min-h-8 items-center gap-2 py-1 px-3 text-[0.7rem] font-semibold bg-[#171925]/62 border border-[#3d4058] rounded-[0.7rem] tn-create-modal__chip--active">
                        <i class="fa-regular fa-calendar-days cursor-pointer text-[13px] text-[#ff896f]"
                            x-on:click.prevent="datepicker.show()"></i>
                        <span>{{ $this->formattedDueAt }}</span>
                        <button type="button" wire:click="clearDueDate"
                            class="ml-1 text-text-muted transition hover:text-text-primary" aria-label="Clear deadline">
                            <i class="fa-solid fa-xmark text-[10px]"></i>
                        </button>
                    </span>
                    @endif
                </div>
                <input type="text" id="dueDate" hidden wire:model="due_at">
            </div>
        </div>

        <div class="border-t border-[#383a50]/72 flex items-center justify-between gap-4 pt-4">
            <button type="button" wire:click.stop="$toggle('starred')" wire:loading.class="animate-pulse"
                class="flex items-center gap-2 rounded-xl border border-transparent px-2 py-2 text-[11px] font-semibold text-[#85899f] hover:border-[#3a3d56] hover:bg-surface-hover hover:text-[#e0e0dd] transform hover:-translate-y-px transition-transform cursor-pointer">
                <i
                    class="{{ $starred ? 'fa-solid text-amber-300' : 'fa-regular text-[#737890]' }} fa-star text-[15px]"></i>
                <span>{{ $starred ? 'Starred' : 'Add to starred' }}</span>
            </button>

            <button type="submit" x-bind:disabled="!taskName.trim()"
                class="inline-flex min-h-8 items-center gap-2 py-2 px-4 text-surface-sidebar text-xs font-extrabold bg-accent rounded-xl shadow-[0_8px_22px_rgb(199_243_107/0.12)] transition-[background-color,transform,opacity] duration-180 motion-reduce:transition-none enabled:cursor-pointer enabled:hover:bg-accent-hover enabled:hover:-translate-y-px disabled:cursor-not-allowed disabled:opacity-[0.35]">
                <span>Save</span>
            </button>
        </div>
    </form>
</x-modal-frame>
