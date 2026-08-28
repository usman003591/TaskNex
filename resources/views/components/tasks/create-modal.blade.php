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
    @if($open)
        <div
            x-data="{ show: false, taskName: '' }"
            x-init="$nextTick(() => {
                show = true;
                requestAnimationFrame(() => requestAnimationFrame(() => $refs.nameInput.focus()));
            })"
            x-on:keydown.escape.window="show = false; setTimeout(() => $wire.closeModal(), 300)"
            class="tn-create-modal fixed inset-0 z-50"
        >
            <style>
                .tn-create-modal {
                    --tn-modal-bg: #1c1d2b;
                    --tn-modal-raised: #222438;
                    --tn-modal-input: #171925;
                    --tn-modal-line: #383a50;
                    --tn-modal-muted: #85899f;
                    --tn-modal-dim: #666b85;
                    --tn-modal-ink: #e0e0dd;
                    --tn-modal-lime: #c7f36b;
                    --tn-modal-coral: #ff896f;
                    font-family: "DM Sans", ui-sans-serif, system-ui, sans-serif;
                }

                .tn-create-modal__panel {
                    background:
                        radial-gradient(circle at 96% 0%, rgb(199 243 107 / 0%), transparent 13rem),
                        var(--tn-modal-bg);
                    border: 1px solid #454860;
                    border-radius: 0.75rem;
                    box-shadow: 0 28px 80px rgb(4 5 10 / 48%), 0 0 0 1px rgb(255 255 255 / 2%);
                }

                .tn-create-modal__title {
                    font-family: "Space Grotesk", ui-sans-serif, system-ui, sans-serif;
                    letter-spacing: -.04em;
                }

                .tn-create-modal__input,
                .tn-create-modal__textarea {
                    width: 100%;
                    color: var(--tn-modal-ink);
                    background: rgb(23 25 37 / 82%);
                    border: 1px solid #3d4058;
                    border-radius: .75rem;
                    outline: none;
                    transition: border-color 180ms ease, box-shadow 180ms ease, background-color 180ms ease;
                }

                .tn-create-modal__input {
                    padding: .5rem 1rem;
                    font-size: .8rem;
                }

                .tn-create-modal__textarea {
                    min-height: 5rem;
                    resize: vertical;
                    padding: .85rem 1rem;
                    font-size: .8rem;
                    line-height: 1.5;
                }

                .tn-create-modal__input::placeholder,
                .tn-create-modal__textarea::placeholder {
                    color: var(--tn-modal-dim);
                }

                .tn-create-modal__input:focus,
                .tn-create-modal__textarea:focus {
                    background: var(--tn-modal-input);
                    border-color: #3d4058;
                    outline: none;
                    box-shadow: none;
                }

                .tn-create-modal__label {
                    display: block;
                    margin: 0 0 .5rem .15rem;
                    color: var(--tn-modal-muted);
                    font-size: .625rem;
                    font-weight: 800;
                    letter-spacing: .16em;
                    text-transform: uppercase;
                }

                .tn-create-modal__chip {
                    display: inline-flex;
                    min-height: 2rem;
                    align-items: center;
                    gap: .5rem;
                    padding: .25rem .75rem;
                    color: var(--tn-modal-muted);
                    font-size: .7rem;
                    font-weight: 600;
                    background: rgb(23 25 37 / 62%);
                    border: 1px solid #3d4058;
                    border-radius: .7rem;
                    transition: color 180ms ease, border-color 180ms ease, background-color 180ms ease;
                }

                .tn-create-modal__chip:hover {
                    color: var(--tn-modal-ink);
                    background: var(--tn-modal-raised);
                    border-color: #565a76;
                }

                .tn-create-modal__footer {
                    border-top: 1px solid rgb(56 58 80 / 72%);
                }

                .tn-create-modal__save {
                    display: inline-flex;
                    min-height: 2rem;
                    align-items: center;
                    gap: .5rem;
                    padding: .5rem 1rem;
                    color: #171825;
                    font-size: .75rem;
                    font-weight: 800;
                    background: var(--tn-modal-lime);
                    border-radius: .75rem;
                    box-shadow: 0 8px 22px rgb(199 243 107 / 12%);
                    transition: background-color 180ms ease, transform 180ms ease, opacity 180ms ease;
                }

                .tn-create-modal__save:hover:not(:disabled) {
                    background: #d6fa87;
                    transform: translateY(-1px);
                }

                .tn-create-modal__save:disabled {
                    cursor: not-allowed;
                    opacity: .35;
                }

                .tn-create-modal__close {
                    display: grid;
                    width: 2rem;
                    height: 2rem;
                    place-items: center;
                    color: var(--tn-modal-muted);
                    background: transparent;
                    border: 1px solid transparent;
                    border-radius: .7rem;
                    transition: color 180ms ease, background-color 180ms ease, border-color 180ms ease;
                }

                .tn-create-modal__close:hover {
                    color: var(--tn-modal-ink);
                    background: var(--tn-modal-raised);
                    /* border-color: var(--tn-modal-line); */
                }

                .tn-create-modal input:focus,
                .tn-create-modal input:focus-visible,
                .tn-create-modal textarea:focus,
                .tn-create-modal textarea:focus-visible {
                    outline: none;
                    box-shadow: none;
                }

                @media (prefers-reduced-motion: reduce) {
                    .tn-create-modal *,
                    .tn-create-modal__input,
                    .tn-create-modal__textarea,
                    .tn-create-modal__chip,
                    .tn-create-modal__save,
                    .tn-create-modal__close {
                        transition-duration: .01ms !important;
                    }
                }
            </style>

            {{-- Backdrop --}}
            <div
                x-show="show"
                x-transition:enter="transition-opacity ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-on:click="show = false; setTimeout(() => $wire.closeModal(), 300)"
                class="absolute inset-0 bg-[#0b0c13]/75 backdrop-blur-md"
                aria-hidden="true"
            ></div>

            {{-- Dialog --}}
            <div class="absolute inset-0 flex items-center justify-center overflow-y-auto p-4 sm:p-6">
                <div
                    x-show="show"
                    x-transition:enter="transition-all ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 scale-[.98]"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition-all ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 scale-[.98]"
                    x-on:click.stop
                    class="tn-create-modal__panel relative my-auto w-full max-w-lg overflow-visible"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="create-task-title"
                >
                    <div class="px-5 pb-7 pt-5 sm:px-6 sm:pt-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <div class="grid mt-1 h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#c7f36b]/10 text-[#c7f36b]">
                                    <i class="fa-solid fa-plus text-sm"></i>
                                </div>
                                <div>
                                    <h2 id="create-task-title" class="tn-create-modal__title text-xl font-semibold text-[#f5f4ef]">
                                        New task
                                    </h2>
                                    <p class="mt-1 text-[11px] text-[#85899f]">
                                        Add the next thing worth making room for.
                                    </p>
                                </div>
                            </div>

                            <button
                                type="button"
                                x-on:click="show = false; setTimeout(() => $wire.closeModal(), 300)"
                                aria-label="Close create task dialog"
                                class="tn-create-modal__close cursor-pointer"
                            >
                                <i class="fa-solid fa-xmark text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <form wire:submit="save" class="space-y-5 px-5 pb-5 sm:px-6 sm:pb-6">
                        {{-- Name --}}
                        <div>
                            <label for="task-name" class="tn-create-modal__label">Task name</label>
                            <input
                                id="task-name"
                                type="text"
                                wire:model="name"
                                x-ref="nameInput"
                                x-on:input="taskName = $event.target.value"
                                class="tn-create-modal__input font-thin"
                                placeholder="What's new on your mind?"
                                autocomplete="off"
                            >
                            @error('name')
                                <small class="mt-1.5 block px-1 text-xs text-[#ff9b87]">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Details --}}
                        <div>
                            <label for="task-details" class="tn-create-modal__label">Details <span class="font-normal normal-case tracking-normal text-[#666b85]">(optional)</span></label>
                            <textarea
                                id="task-details"
                                wire:model="details"
                                rows="2"
                                class="tn-create-modal__textarea"
                                placeholder="Add a little context so future-you knows where to begin."
                            ></textarea>
                        </div>

                        {{-- Task options --}}
                        <div>
                            <div class="tn-create-modal__label">Task options</div>
                            <div class="flex flex-wrap gap-2">
                                {{-- Priority --}}
                                <div x-data="{ priorityDropdownOpen: false }" class="relative">
                                    <button
                                        type="button"
                                        x-on:click.prevent="priorityDropdownOpen = !priorityDropdownOpen"
                                        class="tn-create-modal__chip {{ $priority ? 'tn-create-modal__chip--active' : '' }}"
                                        :aria-expanded="priorityDropdownOpen"
                                    >
                                        <i class="fa-regular fa-flag text-[13px] {{ $priority ? $this->priorityMeta[$priority]['color'] : 'text-[#81c7ff]' }}"></i>
                                        <span>{{ $priority ? $this->priorityMeta[$priority]['label'] : 'Priority' }}</span>
                                        <i class="fa-solid fa-chevron-down ml-1 text-[9px] text-[#666b85] transition-transform" :class="{ 'rotate-180': priorityDropdownOpen }"></i>
                                    </button>

                                    <div
                                        x-show="priorityDropdownOpen"
                                        x-on:click.outside="priorityDropdownOpen = false"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0 -translate-y-1"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        class="absolute left-0 top-11 z-30 min-w-36 overflow-hidden rounded-xl border border-[#383a50] bg-[#222438] py-1.5 shadow-2xl"
                                        style="display: none"
                                    >
                                        <button type="button" wire:click="$set('priority', null)" x-on:click="priorityDropdownOpen = false" class="tn-menu-item">
                                            <i class="fa-regular fa-flag text-[11px] text-[#666b85]"></i>
                                            No priority
                                        </button>
                                        @foreach ($this->priorityMeta as $key => $value)
                                            <button type="button" wire:click="$set('priority', {{ $key }})" x-on:click="priorityDropdownOpen = false" class="tn-menu-item {{ $value['color'] }}">
                                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                                {{ $value['label'] }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Schedule date --}}
                                <div x-data="datepickerComponent('scheduledDate', 'scheduled_at')" x-init="initDatepicker()">
                                    @if(!$scheduled_at)
                                        <button type="button" x-on:click.prevent="datepicker.show()" class="tn-create-modal__chip">
                                            <i class="fa-regular fa-clock text-[13px] text-[#81c7ff]"></i>
                                            <span>Schedule</span>
                                        </button>
                                    @else
                                        <span class="tn-create-modal__chip tn-create-modal__chip--active">
                                            <i class="fa-regular fa-clock cursor-pointer text-[13px] text-[#81c7ff]" x-on:click.prevent="datepicker.show()"></i>
                                            <span>{{ $this->formattedScheduledAt }}</span>
                                            <button type="button" wire:click="clearScheduledDate" class="ml-1 text-[#666b85] transition hover:text-[#f5f4ef]" aria-label="Clear schedule">
                                                <i class="fa-solid fa-xmark text-[10px]"></i>
                                            </button>
                                        </span>
                                    @endif
                                </div>
                                <input type="text" id="scheduledDate" hidden wire:model="scheduled_at">

                                {{-- Due date --}}
                                <div x-data="datepickerComponent('dueDate', 'due_at')" x-init="initDatepicker()">
                                    @if(!$due_at)
                                        <button type="button" x-on:click.prevent="datepicker.show()" class="tn-create-modal__chip">
                                            <i class="fa-regular fa-calendar-check text-[13px] text-[#ff896f]"></i>
                                            <span>Deadline</span>
                                        </button>
                                    @else
                                        <span class="tn-create-modal__chip tn-create-modal__chip--active">
                                            <i class="fa-regular fa-calendar-check cursor-pointer text-[13px] text-[#ff896f]" x-on:click.prevent="datepicker.show()"></i>
                                            <span>{{ $this->formattedDueAt }}</span>
                                            <button type="button" wire:click="clearDueDate" class="ml-1 text-[#666b85] transition hover:text-[#f5f4ef]" aria-label="Clear deadline">
                                                <i class="fa-solid fa-xmark text-[10px]"></i>
                                            </button>
                                        </span>
                                    @endif
                                </div>
                                <input type="text" id="dueDate" hidden wire:model="due_at">
                            </div>
                        </div>

                        <div class="tn-create-modal__footer flex items-center justify-between gap-4 pt-4">
                            <button
                                type="button"
                                wire:click.stop="$toggle('starred')"
                                wire:loading.class="animate-pulse"
                                class="flex items-center gap-2 rounded-lg px-2 py-2 text-[11px] font-semibold text-[#85899f] transition hover:bg-[#222438] hover:text-[#e0e0dd] cursor-pointer">
                                <i class="{{ $starred ? 'fa-solid text-amber-300' : 'fa-regular text-[#737890]' }} fa-star text-[15px]"></i>
                                <span>{{ $starred ? 'Starred' : 'Add to starred' }}</span>
                            </button>

                            <button
                                type="submit"
                                x-bind:disabled="!taskName.trim()"
                                class="tn-create-modal__save">
                                <span>Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Floating add button --}}
    <button
        type="button"
        wire:click="openModal"
        aria-label="New task"
        title="Add new task"
        class="fixed bottom-6 right-6 z-40 grid h-13 w-13 place-items-center rounded-full bg-lime-300 text-[#171825] shadow-[0_10px_28px_rgba(199,243,107,.2)] transition-all duration-150 hover:-translate-y-1 hover:bg-[#d6fa87] active:scale-95"
    >
        <i class="fa-solid fa-plus text-lg"></i>
    </button>
</div>
