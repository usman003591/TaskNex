<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\TaskList;
use Carbon\Carbon;

new class extends Component
{
    public TaskList $list;
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


    public function mount(TaskList $list): void
    {
        $this->list = $list;
    }

    #[Computed]
    public function tasks()
    {
        return $this->list->tasks()->orderBy('is_completed')->latest()->get();
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

    public function openModal()
    {
        $this->open = true;
    }

    public function closeModal(){
        $this->reset(['open', 'name', 'details', 'scheduled_at', 'due_at', 'priority']);
        $this->resetValidation();
    }

    public function clearScheduledDate(): void
    {
        $this->scheduled_at = null;
    }

    public function clearDueDate(): void
    {
        $this->due_at = null;
    }



    public function countTasks(): int
    {
        return $this->list->tasks()->count();
    }

    public function countCompletedTasks(): int
    {
        return $this->list->tasks()->where('is_completed', true)->count();
    }

    public function toggleComplete(int $taskId): void
    {
        $task = $this->list->tasks()->findOrFail($taskId);
        $task->update([
            'is_completed' => !$task->is_completed,         //for inverse
            'completed_at' => $task->completed_at ? null : now(),
            ]);
    }

    public function toggleStarred(int $taskId): void
    {
        $task = $this->list->tasks()->findOrFail($taskId);
        $task->update([
            'starred' => !$task->starred,         //for inverse
            ]);
    }

    public function save()
    {
        $this->validate();

        $this->list->tasks()->create([
            'name' => $this->name,
            'details' => $this->details ?? null,
            'scheduled_at' => $this->scheduled_at ?? null,
            'due_at' => $this->due_at ?? null,
            'priority' => $this->priority ?: null,
        ]);

        $this->closeModal();
    }
};
?>

<div>
    <div>
        <div class="mb-4 flex flex-col gap-0.5">
            <h2 class="text-2xl font-medium text-white leading-tight">{{ ucfirst($list->name) }}</h2>
            <small class="text-xs text-gray-500 leading-tight">{{ $this->countTasks() }} tasks, {{
                $this->countCompletedTasks() }} completed</small>
        </div>

        {{-- Task list --}}
        <div class="bg-gray-900 border border-white/10 rounded-lg divide-y divide-white/10 mb-24">
            @forelse($this->tasks as $task)
            <div class="group px-4 py-3 hover:bg-white/[0.03] transition-colors cursor-pointer"
                wire:key="task-{{ $task->id }}">
                <div class="flex items-center gap-3">
                    <button type="button" wire:click.stop="toggleComplete({{ $task->id }})" class="shrink-0">
                        <div class="w-4 h-4 rounded-[4px] border-2 flex items-center justify-center transition-colors cursor-pointer
                                    {{ $task->is_completed ? 'bg-accent border-accent' : 'border-gray-600' }}">
                            @if($task->is_completed)
                            <i class="fa-solid fa-check text-[9px] text-white"></i>
                            @endif
                        </div>
                    </button>

                    <span
                        class="flex-1 text-sm {{ $task->is_completed ? 'text-gray-500 line-through' : 'text-gray-200' }}">
                        {{ $task->name }}
                    </span>

                    <button type="button" wire:click.stop="toggleStarred({{ $task->id }})"
                        wire:loading.class="animate-pulse" wire:target="toggleStarred({{ $task->id }})"
                        class="shrink-0 cursor-pointer transition-transform duration-200 hover:scale-110 active:scale-125">
                        @if($task->starred)
                        <i
                            class="fa-solid fa-star text-base text-yellow-500 transition-all duration-300 ease-out scale-110"></i>
                        @else
                        <i
                            class="fa-regular fa-star text-base flex items-center justify-center text-yellow-500 transition-all duration-300 ease-out scale-100"></i>
                        @endif
                    </button>
                </div>

                {{-- @if($task->due_at || $task->subtasks_count || $task->priority)
                <div class="flex items-center gap-2 mt-2 ml-7">
                    @if($task->due_at)
                    <span class="flex items-center gap-1 text-[11px] px-2 py-0.5 rounded-md bg-white/5 text-gray-400">
                        <i class="fa-regular fa-calendar text-[10px]"></i>
                        {{ $task->due_at->format('d-m-y') }}
                    </span>
                    @endif

                    @if($task->subtasks_count)
                    <span class="flex items-center gap-1 text-[11px] px-2 py-0.5 rounded-md bg-white/5 text-gray-400">
                        <i class="fa-solid fa-list-check text-[10px]"></i>
                        {{ $task->subtasks_count }} Subtasks
                    </span>
                    @endif

                    @if($task->priority)
                    @php
                    $labels = [1 => 'Low', 2 => 'Medium', 3 => 'High'];
                    $classes = [
                    1 => 'bg-priority-low-bg text-priority-low-text',
                    2 => 'bg-priority-medium-bg text-priority-medium-text',
                    3 => 'bg-priority-high-bg text-priority-high-text',
                    ];
                    @endphp
                    <span class="text-[11px] px-2 py-0.5 rounded-md {{ $classes[$task->priority] }}">
                        {{ $labels[$task->priority] }}
                    </span>
                    @endif
                </div>
                @endif --}}
            </div>
            @empty
            <div class="px-4 py-10 text-center text-sm text-gray-500">
                No tasks yet — tap the + button to add one.
            </div>
            @endforelse
        </div>

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


                        <div>
                            <button type="button" x-on:click.prevent=""
                                class="inline-flex items-center gap-2 text-xs font-normal px-3 py-1.5 rounded-lg bg-transparent border border-white/10 cursor-pointer focus:outline-none focus:border-gray-600 focus:ring-0 focus:ring-gray-500/20 hover:outline-none hover:border-gray-600 hover:ring-0 hover:ring-gray-500/20">
                                <i class="fa-regular fa-flag text-[14px] text-blue-500"></i>
                                <p class="text-gray-500">Select priority</p>
                                <i class="fa-solid fa-chevron-down text-[10px] text-gray-500"></i>
                            </button>
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
                                {{-- <button type="button" wire:click.stop="toggleStarred({{ $task->id }})"
                                    wire:loading.class="animate-pulse" wire:target="toggleStarred({{ $task->id }})"
                                    class="shrink-0 cursor-pointer transition-transform duration-200 hover:scale-110 active:scale-125">
                                    @if($task->starred)
                                    <i
                                        class="fa-solid fa-star text-base text-yellow-500 transition-all duration-300 ease-out scale-110"></i>
                                    @else
                                    <i
                                        class="fa-regular fa-star text-base flex items-center justify-center text-yellow-500 transition-all duration-300 ease-out scale-100"></i>
                                    @endif
                                </button> --}}

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
    </div>
    <button type="button" wire:click="openModal" aria-label="New task" title="Add new task"
        class="fixed bottom-6 right-6 z-50 flex items-center justify-center size-13 rounded-full bg-blue-500 text-white hover:bg-blue-400 hover:scale-105 active:scale-95 transition-all duration-150">
        <i class="fa-solid fa-plus text-lg"></i>
    </button>

</div>
