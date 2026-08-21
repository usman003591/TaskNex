<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\TaskList;
use Carbon\Carbon;

new class extends Component
{
    public TaskList $list;

    public function mount(TaskList $list): void
    {
        $this->list = $list;
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

    #[Computed]
    public function tasks()
    {
        return $this->list->tasks()->orderBy('is_completed')->latest()->get();
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

    public function deleteList()
    {
        $this->list->tasks()->delete();
        $this->list->delete();

        $this->redirect(route('dashboard'), navigate:true);
    }

    public function deleteCompletedTasks()
    {
        $this->list->tasks()->where('is_completed', true)->delete();
    }

    #[On('task-created')]               //adding a listener for the child component
    public function refreshTasks(){
        unset($this->tasks);            //computed property cache clear
    }

    #[On('list-renamed')]
    public function refreshLists(){
        $this->list->refresh();            //computed property cache clear
    }
};
?>

<div>
    <div>
        <div class="mb-4 flex items-center">
            <div class="flex flex-col gap-0.5">
                <h2 class="text-2xl font-medium text-white leading-tight">{{ ucfirst($list->name) }}</h2>
                <small class="text-xs text-gray-500 leading-tight">{{ $this->countTasks() }} tasks, {{
                    $this->countCompletedTasks() }} completed</small>
            </div>
            <div class="flex ml-auto">
                <div x-data="{optionsDropdown: false}" class="relative inline-block">
                    <button type="button" x-on:click="optionsDropdown = !optionsDropdown"
                        class="hover:scale-110 active:scale-125 cursor-pointer transition-all duration-300 ease-out">
                        <i class="fa-solid fa-ellipsis-vertical scale-100 p-2"></i>
                    </button>
                    <div x-show="optionsDropdown" x-on:click.outside="optionsDropdown = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute right-0 z-10 mt-1.5 bg-gray-900 border border-white/10 rounded-lg w-47 max-w-[calc(100vw-2rem)] shadow-xl overflow-hidden"
                        style="display: none">

                        <button type="button" wire:click="deleteList"
                            wire:confirm='Are you sure you want to delete this list?'
                            x-on:click="optionsDropdown = false"
                            class="flex items-center gap-2 w-full px-3 py-2 text-xs font-normal text-gray-300 hover:bg-white/5 transition-colors cursor-pointer">
                            <i class="fa-solid fa-trash text-xs"></i> Delete List
                        </button>
                        <button type="button" wire:click="$dispatch('open-edit-list-modal')"
                            x-on:click="optionsDropdown = false"
                            class="flex items-center gap-2 w-full py-2 px-3 text-xs font-normal text-gray-300 hover:bg-white/5 transition-colors cursor-pointer">
                            <i class="fa-solid fa-edit text-xs"></i> Rename List
                        </button>
                        <button type="button" wire:click="deleteCompletedTasks" x-on:click="optionsDropdown = false"
                            class="flex items-center gap-2 w-full py-2 px-3 text-xs font-normal text-gray-300 hover:bg-white/5 transition-colors cursor-pointer">
                            <i class="fa-solid fa-trash-arrow-up text-xs"></i> Delete all completed tasks
                        </button>

                    </div>
                </div>
            </div>
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
                    <span
                        class="flex text-[11px] px-2 py-0.5 rounded-md {{ $this->priorityMeta[$task->priority]['color'] }}">
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



                    {{-- @if($task->subtasks_count)
                    <span class="flex items-center gap-1 text-[11px] px-2 py-0.5 rounded-md bg-white/5 text-gray-400">
                        <i class="fa-solid fa-list-check text-[10px]"></i>
                        {{ $task->subtasks_count }} Subtasks
                    </span>
                    @endif --}}


                </div>
                @endif
            </div>
            @empty
            <div class="px-4 py-10 text-center text-sm text-gray-500">
                No tasks yet — tap the + button to add one.
            </div>
            @endforelse
        </div>
        <livewire:lists.edit-modal :list="$list" />
        <livewire:tasks.create-modal :list="$list" />
    </div>


</div>
