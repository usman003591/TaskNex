<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Task;

new class extends Component
{
    #[Computed]
    public function tasks()
    {
        return Task::where('starred', true)->where('is_completed', false)->latest()->get();
    }

    #[Computed]
    public function priorityMeta(): array
    {
        return [
            1 => ['label' => 'Urgent', 'color' => 'text-red-400 bg-red-500/10'],
            2 => ['label' => 'Medium', 'color' => 'text-amber-400 bg-amber-500/10'],
            3 => ['label' => 'Low', 'color' => 'text-emerald-400 bg-emerald-500/10']
        ];
    }

    public function countTasks(): int
    {
        return Task::where('starred', true)->where('is_completed', false)->count();
    }
};
?>

<div>
    <div>
        <div class="mb-4 flex flex-col gap-0.5">
            <h2 class="text-2xl font-medium text-white leading-tight">Starred</h2>
            <small class="text-xs text-gray-500 leading-tight">{{ $this->countTasks() }} tasks </small>
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

                    @if($task->priority)
                    <span class="flex text-[11px] px-2 py-0.5 rounded-md {{ $this->priorityMeta[$task->priority]['color'] }}">
                        {{ $this->priorityMeta[$task->priority]['label'] }}
                    </span>
                    @endif

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

                @if($task->due_at || $task->scheduled_at || $task->priority)
                <div class="flex items-center gap-2 mt-2 ml-7">

                    @if($task->scheduled_at)
                    <span class="flex items-center gap-2 text-[11px] px-2 py-0.5 text-gray-400">
                        <i class="fa-regular fa-clock pt-0.5"></i>
                        {{ $task->scheduled_at->diffForHumans(['short' => true]) }}
                    </span>
                    @endif

                    @if($task->due_at)
                    <span class="flex items-center gap-2 text-[11px] px-2 py-0.5 {{ $task->due_status['color'] }}">
                        <i class="fa-regular fa-calendar-days pt-0.5"></i>
                        {{ $task->due_status['label'] }}
                    </span>
                    @endif

                </div>
                @endif
            </div>
            @empty
            <div class="px-4 py-10 text-center text-sm text-gray-500">
                No tasks yet — tap the + button to add one.
            </div>
            @endforelse
        </div>

    </div>


</div>
