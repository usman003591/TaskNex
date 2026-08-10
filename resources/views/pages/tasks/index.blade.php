<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use App\Models\TaskList;

new class extends Component
{
    public TaskList $list;
    public bool $open = false;

    #[Validate('required|string|max:255')]
    public string $name;
    #[Validate('nullable|string|max:255')]
    public string $details;
    // public bool $starred = false;
    // public bool $is_completed = false;


    public function mount(TaskList $list): void
    {
        $this->list = $list;
    }

    public function openModal(){
        $this->open = true;
    }

    public function closeModal(){
        $this->reset(['open', 'name', 'details']);
        $this->resetValidation();
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
            // 'starred' => $this->starred ?: null,
            // 'is_completed' => $this->is_completed ?: null,
        ]);

        $this->closeModal();
    }
};
?>

<div>
    <div>
        <div class="mb-4 flex flex-col gap-0.5">
            <h2 class="text-2xl font-medium text-white leading-tight">{{ ucfirst($list->name) }}</h2>
            <small class="text-xs text-gray-500 leading-tight">{{ $this->countTasks() }} tasks, {{ $this->countCompletedTasks() }} completed</small>
        </div>

        {{-- Task list --}}
        <div class="bg-gray-900 border border-white/10 rounded-lg divide-y divide-white/10 mb-24">
            @forelse($list->tasks as $task)
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
                        <i class="fa-solid fa-star text-base text-yellow-500 transition-all duration-300 ease-out scale-110"></i>
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

        {{--
        <!-- Floating action button -->
        <button type="button" wire:click="openModal" aria-label="New task"
            class="fixed bottom-6 right-6 z-50 flex items-center justify-center size-13 rounded-full bg-accent text-white shadow-lg shadow-accent/40 hover:bg-accent-hover hover:scale-105 active:scale-95 transition-all duration-150">
            <i class="fa-solid fa-plus text-lg"></i>
        </button> --}}

        <!-- Modal -->
        @if($open)
        <div x-data x-on:keydown.escape.window="$wire.closeModal()"
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/60"></div>

            <div class="relative w-full max-w-md bg-gray-900 border border-none rounded-xl shadow-xl p-5">
                <button type="button" wire:click="closeModal" aria-label="New task" title="Add new task"
                    class="absolute top-3 right-3 z-50 flex size-4 items-center justify-center rounded-full text-gray-700 hover:text-accent-hover hover:scale-105 active:scale-95 transition-all duration-150">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>

                {{-- <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-medium text-white">New task in {{ $list->name }}</h2>
                    <button type="button" wire:click="closeModal" class="text-gray-500 hover:text-white">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div> --}}

                <form wire:submit="save" class="space-y-4">
                    <div class="w-full space-y-3">
                        {{-- <div class="relative"> --}}
                            <input type="text" wire:model="name"
                                class="py-2.5 sm:py-3 pe-0 ps-2.5 block w-full bg-transparent sm:text-sm text-gray-200 dark:text-neutral-200 placeholder:text-gray-500 dark:placeholder:text-neutral-400 focus:border-b focus:outline-none focus:ring-0 disabled:opacity-50 disabled:pointer-events-none"
                                placeholder="New task">
                            @error('name')
                            <small class="text-xs text-red-400 px-1">{{ $message }}</small>
                            @enderror
                            {{-- <div
                                class="absolute inset-y-0 inset-s-0 flex items-center pointer-events-none ps-2 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-400"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z" />
                                    <circle cx="16.5" cy="7.5" r=".5" />
                                </svg>
                            </div> --}}
                            {{--
                        </div> --}}
                    </div>

                    {{-- <div>
                        <label class="block text-xs text-gray-400 mb-1.5">Details</label>
                        <textarea wire:model="details" rows="2" placeholder="Optional notes"
                            class="w-full rounded-lg bg-gray-800 border border-white/10 px-3 py-2 text-sm text-white placeholder:text-gray-500 focus:outline-hidden focus:border-indigo-500 resize-none"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs text-gray-400 mb-1.5">Due date</label>
                            <input type="date" wire:model="due_at"
                                class="w-full rounded-lg bg-gray-800 border border-white/10 px-3 py-2 text-sm text-white focus:outline-hidden focus:border-indigo-500" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 mb-1.5">Priority</label>
                            <select wire:model="priority"
                                class="w-full rounded-lg bg-gray-800 border border-white/10 px-3 py-2 text-sm text-white focus:outline-hidden focus:border-indigo-500">
                                <option value="">None</option>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                            </select>
                        </div>
                    </div> --}}

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="submit"
                            class="rounded-md px-3 py-1.5 text-sm font-medium text-accent hover:text-accent-hover">
                            Create task
                        </button>
                    </div>

                </form>
            </div>
        </div>
        @endif
    </div>
    <button type="button" wire:click="openModal" aria-label="New task" title="Add new task"
        class="fixed bottom-6 right-6 z-50 flex items-center justify-center size-13 rounded-full bg-accent text-white hover:bg-accent-hover hover:scale-105 active:scale-95 transition-all duration-150">
        <i class="fa-solid fa-plus text-lg"></i>
    </button>
</div>
