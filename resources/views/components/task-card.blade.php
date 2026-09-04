@props(['task', 'checkIconColor'])

<article {{ $attributes->merge(['class' => 'group rounded-2xl border border-[#2d3044] bg-[#1b1d2a]/[0.88] px-4 py-4
    cursor-pointer
    transition-[background-color,border-color,transform,box-shadow] duration-[180ms] motion-reduce:transition-none
    hover:-translate-y-0.5 hover:border-[#494b62] hover:bg-[#202238] hover:shadow-[0_12px_30px_rgb(7_8_14_/_0.12)]
    data-[completed=true]:border-[#2b2d40] data-[completed=true]:bg-[#1b1d2a]/[0.72] sm:px-5']) }}
    data-completed="{{ $task->is_completed ? 'true' : 'false' }}" wire:key="task-{{ $task->id }}">

    <div class="flex items-start gap-3 sm:items-center sm:gap-4"
        x-data="{ goTo() { Livewire.navigate('{{ route('tasks.details', ['list' => $task->list_id, 'task' => $task->id]) }}') } }"
        x-on:click="goTo()">
        <button type="button" wire:click.stop="toggleComplete({{ $task->id }})" wire:loading.class="animate-pulse"
            wire:target="toggleComplete({{ $task->id }})" style="--check-icon-color: {{ $checkIconColor }}"
            class="mt-0.5 grid h-[1.375rem] w-[1.375rem] flex-none place-items-center rounded-full border-[1.5px] border-[#596079] text-[#171825] transition-colors duration-[180ms] motion-reduce:transition-none hover:scale-[1.06] hover:border-[var(--check-icon-color)] hover:bg-[var(--check-icon-color)/0.12] data-[completed=true]:border-[var(--check-icon-color)] data-[completed=true]:bg-[var(--check-icon-color)] cursor-pointer"
            data-completed="{{ $task->is_completed ? 'true' : 'false' }}"
            aria-label="{{ $task->is_completed ? 'Mark task incomplete' : 'Mark task complete' }}">
            @if($task->is_completed)
            <i class="fa-solid fa-check text-[10px]"></i>
            @endif
        </button>

        <div class="min-w-0 flex-1">
            <div
                class="text-[13px] font-semibold tracking-[-.01em] {{ $task->is_completed ? 'text-[#70758b] line-through' : 'text-[#e9e7e0]' }}">
                {{ $task->name }}
            </div>

            @if($task->due_at || $task->scheduled_at || $task->priority)
            <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1.5">
                @if($task->scheduled_at)
                <span class="flex items-center gap-1.5 text-[0.6875rem] text-[#85899f]">
                    <i class="fa-regular fa-clock text-[10px]"></i>
                    {{ $task->scheduled_at->diffForHumans(['short' => true]) }}
                </span>
                @endif

                @if($task->due_at)
                <span class="flex items-center gap-1.5 text-[0.6875rem] {{ $task->due_status['color'] }}">
                    <i class="fa-regular fa-calendar-days text-[10px]"></i>
                    {{ $task->due_status['label'] }}
                </span>
                @endif
            </div>
            @endif
        </div>

        <div class="flex shrink-0 items-center gap-1.5">
            @if($task->priority)
            <span
                class="hidden rounded-full border {{ $this->priorityMeta[$task->priority]['classes'] }} px-2 py-1 text-[11px] font-medium tracking-[0.015rem] sm:inline-flex">
                {{ $this->priorityMeta[$task->priority]['label'] }}
            </span>
            @endif

            <button type="button" wire:click.stop="toggleStarred({{ $task->id }})" wire:loading.class="animate-pulse"
                wire:target="toggleStarred({{ $task->id }})" class="tn-icon-button cursor-pointer"
                aria-label="{{ $task->starred ? 'Remove task from starred' : 'Add task to starred' }}">
                <i
                    class="{{ $task->starred ? 'fa-solid' : 'fa-regular' }} fa-star text-[14px] {{ $task->starred ? 'text-amber-300' : 'text-[#737890]' }}"></i>
            </button>
        </div>
    </div>
</article>
