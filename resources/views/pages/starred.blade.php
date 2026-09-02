<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Task;

new class extends Component
{
    #[Computed]
    public function starredTasks()
    {
        return Task::where('starred', true)->latest()->get();
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

    public function toggleComplete(int $taskId): void
    {
        $task = Task::findOrFail($taskId);
        $task->update([
            'is_completed' => !$task->is_completed,         //for inverse
            'completed_at' => $task->is_completed ? null : now(),
            ]);
    }

    public function toggleStarred(int $taskId): void
    {
        $task = Task::findOrFail($taskId);
        $task->update([
            'starred' => !$task->starred,         //for inverse
            ]);
    }

    public function countStarredTasks(): int
    {
        return Task::where('starred', true)->count();
    }
    public function countCompletedStarredTasks(): int
    {
        return Task::where('starred', true)->where('is_completed', true)->count();
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
                Starred<span class="text-[#f5c451]">.</span>
            </h1>
            <p class="mt-4 text-[13px] text-[#85899f]">
                {{ $this->countStarredTasks() }} starred {{ Str::plural('task', $this->countStarredTasks()) }}
                <span class="px-1 text-[#4f536b]">|</span>
                {{ $this->countCompletedStarredTasks() }} completed
            </p>
        </div>

        <div class="flex items-center gap-3 sm:pb-1">
            <div class="hidden text-right sm:block">
                <div class="font-['Space_Grotesk'] text-lg font-semibold text-[#f5f4ef]">
                    {{ $this->countStarredTasks() - $this->countCompletedStarredTasks() }}
                    <span class="text-[#666b85]">/ {{ $this->countStarredTasks() }}</span>
                </div>
                <div class="text-[10px] uppercase tracking-[.14em] text-[#666b85]">in progress</div>
            </div>
        </div>
    </div>

    <div class="mb-6 grid gap-3">
        <div class="relative overflow-hidden rounded-2xl border border-[#34364c] bg-[#1d1f2e] p-5">
            <div class="relative">
                <div class="mb-4 flex items-center justify-between">
                    <span class="flex items-center gap-2 text-[11px] font-semibold text-[#a8abbc]">
                        <i class="fa-solid fa-wand-magic-sparkles text-[#f5c451]"></i>
                        Collection pulse
                    </span>
                </div>
                <div class="flex items-end gap-3">
                    <span class="font-['Space_Grotesk'] text-4xl font-semibold tracking-[-.06em] text-[#f6f2ea]">
                        {{ $this->countCompletedStarredTasks() }}<span class="text-[#f5c451]">.</span>
                    </span>
                    <span class="mb-1 text-[12px] text-[#85899f]">tasks checked off</span>
                </div>
                <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-[#303249]">
                    <div
                        class="h-full rounded-full bg-[#f5c451] transition-all duration-500"
                        style="width: {{ $this->countStarredTasks() > 0 ? ($this->countCompletedStarredTasks() / $this->countStarredTasks()) * 100 : 0 }}%"
                    ></div>
                </div>
            </div>
        </div>

        {{-- <div class="rounded-2xl border border-[#34364c] bg-[#1d1f2e] p-5">
            <div class="mb-4 flex items-center justify-between">
                <span class="text-[11px] font-semibold text-[#a8abbc]">List rhythm</span>
                <i class="fa-solid fa-bolt text-[#ff896f]"></i>
            </div>
            <div class="font-['Space_Grotesk'] text-2xl font-semibold tracking-[-.04em] text-[#f5f4ef]">
                {{ $this->countStarredTasks() - $this->countCompletedStarredTasks() }}
            </div>
            <div class="mt-1 text-[11px] text-[#85899f]">important tasks still waiting for you</div>
        </div> --}}
    </div>

    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <h2 class="font-['Space_Grotesk'] text-[15px] font-semibold tracking-[-.02em]">All tasks</h2>
            <span class="rounded-md bg-[#25273a] px-1.5 py-0.5 text-[10px] font-bold text-[#85899f]">{{ $this->countStarredTasks() }}</span>
        </div>
        <span class="text-[10px] uppercase tracking-[.14em] text-[#666b85]">Latest first</span>
    </div>

    {{-- Task list --}}
    <div class="space-y-2">
        @forelse($this->starredTasks as $task)
            <x-task-card :task="$task" checkIconColor="#f5c451"/>
        @empty
            <x-empty-list-state icon="fa-solid fa-angles-down" title="No starred task yet" subtitle="Tap the add button in a list to create one."/>
        @endforelse
    </div>

    <div class="mt-7 flex items-center justify-between text-[10px] text-[#5e637a]">
        <span class="flex items-center gap-1.5">
            <span class="h-1.5 w-1.5 rounded-full bg-[#f5c451]"></span>
            Everything is up to date
        </span>
    </div>

</div>
