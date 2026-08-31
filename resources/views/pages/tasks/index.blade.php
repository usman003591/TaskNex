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

<div class="mx-auto w-full max-w-[1100px] pb-24 text-[#f5f4ef] font-['DM_Sans']">

    <div class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-3 flex items-center gap-2 text-[10px] font-bold uppercase tracking-[.2em] text-[#7f849d]">
                <span class="h-1.5 w-1.5 rounded-full bg-[#ff896f]"></span>
                Personal collection
            </div>
            <h1 class="font-['Space_Grotesk'] text-[clamp(2.25rem,5vw,4rem)] font-semibold leading-none tracking-[-.065em] text-[#f7f4ed]">
                {{ ucfirst($list->name) }}<span class="text-[#c7f36b]">.</span>
            </h1>
            <p class="mt-4 text-[13px] text-[#85899f]">
                {{ $this->countTasks() }} {{ Str::plural('task', $this->countTasks()) }}
                <span class="px-1 text-[#4f536b]">|</span>
                {{ $this->countCompletedTasks() }} completed
            </p>
        </div>

        <div class="flex items-center gap-3 sm:pb-1">
            <div class="hidden text-right sm:block">
                <div class="font-['Space_Grotesk'] text-lg font-semibold text-[#f5f4ef]">
                    {{ $this->countTasks() - $this->countCompletedTasks() }}
                    <span class="text-[#666b85]">/ {{ $this->countTasks() }}</span>
                </div>
                <div class="text-[10px] uppercase tracking-[.14em] text-[#666b85]">in progress</div>
            </div>

            <div class="hidden h-10 w-px bg-[#303249] sm:block"></div>

            <div x-data="{ optionsDropdown: false }" class="relative">
                <button
                    type="button"
                    x-on:click="optionsDropdown = !optionsDropdown"
                    class="tn-icon-button"
                    :aria-expanded="optionsDropdown"
                    aria-label="List options"
                >
                    <i class="fa-solid fa-ellipsis text-[14px]"></i>
                </button>

                <div
                    x-show="optionsDropdown"
                    x-on:click.outside="optionsDropdown = false"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute right-0 top-11 z-10 min-w-[13rem] overflow-hidden rounded-[0.85rem] border border-[#383a50] bg-[#222438] shadow-[0_18px_40px_rgb(4_5_10_/_0.35)]"
                    style="display: none"
                >
                    <button
                        type="button"
                        wire:click="deleteList"
                        wire:confirm="Are you sure you want to delete this list?"
                        x-on:click="optionsDropdown = false"
                        class="flex w-full items-center gap-2.5 px-3.5 py-[0.7rem] text-left text-xs text-[#c4c5ce] transition-colors duration-[180ms] motion-reduce:transition-none hover:bg-[#303249] hover:text-[#ff896f]"
                    >
                        <i class="fa-solid fa-trash-can text-[11px]"></i>
                        Delete list
                    </button>
                    <button
                        type="button"
                        wire:click="$dispatch('open-edit-list-modal')"
                        x-on:click="optionsDropdown = false"
                        class="flex w-full items-center gap-2.5 px-3.5 py-[0.7rem] text-left text-xs text-[#c4c5ce] transition-colors duration-[180ms] motion-reduce:transition-none hover:bg-[#303249] hover:text-[#f5f4ef]"
                    >
                        <i class="fa-solid fa-pen text-[11px]"></i>
                        Rename list
                    </button>
                    <button
                        type="button"
                        wire:click="deleteCompletedTasks"
                        x-on:click="optionsDropdown = false"
                        @if($this->countCompletedTasks() <= 0) hidden disabled @endif
                        class="flex w-full items-center gap-2.5 px-3.5 py-[0.7rem] text-left text-xs text-[#c4c5ce] transition-colors duration-[180ms] motion-reduce:transition-none hover:bg-[#303249] hover:text-[#f5f4ef]"
                    >
                        <i class="fa-solid fa-broom text-[11px]"></i>
                        Clear completed tasks
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6 grid gap-3 sm:grid-cols-[1.4fr_1fr]">
        <div class="relative overflow-hidden rounded-2xl border border-[#34364c] bg-[#1d1f2e] p-5">
            <div class="absolute -right-8 -top-10 h-32 w-32 rounded-full bg-[#c7f36b]/10 blur-3xl"></div>
            <div class="relative">
                <div class="mb-4 flex items-center justify-between">
                    <span class="flex items-center gap-2 text-[11px] font-semibold text-[#a8abbc]">
                        <i class="fa-solid fa-wand-magic-sparkles text-[#c7f36b]"></i>
                        Collection pulse
                    </span>
                    <span class="rounded-full bg-[#c7f36b]/10 px-2 py-1 text-[10px] font-bold text-[#c7f36b]">TODAY</span>
                </div>
                <div class="flex items-end gap-3">
                    <span class="font-['Space_Grotesk'] text-4xl font-semibold tracking-[-.06em] text-[#f6f2ea]">
                        {{ $this->countCompletedTasks() }}<span class="text-[#c7f36b]">.</span>
                    </span>
                    <span class="mb-1 text-[12px] text-[#85899f]">tasks checked off</span>
                </div>
                <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-[#303249]">
                    <div
                        class="h-full rounded-full bg-[#c7f36b] transition-all duration-500"
                        style="width: {{ $this->countTasks() > 0 ? ($this->countCompletedTasks() / $this->countTasks()) * 100 : 0 }}%"
                    ></div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-[#34364c] bg-[#1d1f2e] p-5">
            <div class="mb-4 flex items-center justify-between">
                <span class="text-[11px] font-semibold text-[#a8abbc]">List rhythm</span>
                <i class="fa-solid fa-bolt text-[#ff896f]"></i>
            </div>
            <div class="font-['Space_Grotesk'] text-2xl font-semibold tracking-[-.04em] text-[#f5f4ef]">
                {{ $this->countTasks() - $this->countCompletedTasks() }}
            </div>
            <div class="mt-1 text-[11px] text-[#85899f]">tasks still waiting for you</div>
        </div>
    </div>

    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <h2 class="font-['Space_Grotesk'] text-[15px] font-semibold tracking-[-.02em]">All tasks</h2>
            <span class="rounded-md bg-[#25273a] px-1.5 py-0.5 text-[10px] font-bold text-[#85899f]">{{ $this->countTasks() }}</span>
        </div>
        <span class="text-[10px] uppercase tracking-[.14em] text-[#666b85]">Latest first</span>
    </div>

    {{-- Task list --}}
    <div class="space-y-2">
        @forelse($this->tasks as $task)
            <x-task-card :task="$task"/>
        @empty
            <x-empty-list-state icon="fa-solid fa-circle-down" title="This list is ready for its first task" subtitle="Tap the add button to capture what's next."/>
        @endforelse
    </div>

    <button
        type="button"
        wire:click="$dispatch('open-create-task-modal')"
        class="mt-4 flex w-full items-center gap-3 rounded-2xl border border-dashed border-[#3b3e55] px-4 py-4 text-left text-[12px] font-medium text-[#737890] transition hover:border-[#c7f36b]/40 hover:bg-[#1b1d2a] hover:text-[#c7f36b]"
    >
        <span class="grid h-6 w-6 place-items-center rounded-lg border border-current">
            <i class="fa-solid fa-plus text-[11px]"></i>
        </span>
        Add another task
    </button>

    <div class="mt-7 flex items-center justify-between text-[10px] text-[#5e637a]">
        <span>List updated just now</span>
        <span class="flex items-center gap-1.5">
            <span class="h-1.5 w-1.5 rounded-full bg-[#c7f36b]"></span>
            Everything is up to date
        </span>
    </div>

    <livewire:lists.edit-modal :list="$list" />
    <livewire:tasks.create-modal :list="$list" />
</div>
