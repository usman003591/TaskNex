<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\TaskList;
use App\Models\Task;
use App\Livewire\Traits\HasPriority;

new class extends Component
{
    use hasPriority;
    public TaskList $list;
    public Task $task;

    #[Computed]
    public function status(): array
    {
        if ($this->task->is_completed) {
            return ['label' => 'Completed', 'classes' => 'bg-lime-500/10 text-lime-500 border border-green-500/20'];
        }

        return ['label' => 'In Progress', 'classes' => 'bg-[#1C293F] text-[#7BD0FF] border border-[#2B4063]'];
    }
};
?>

<div class="mx-auto w-full max-w-[1200px] pb-24 text-[#f5f4ef] font-['DM_Sans']">
    <div class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-3 flex items-center gap-2 text-[10px] font-bold uppercase tracking-[.2em] text-[#7f849d]">
                <span class="h-1.5 w-1.5 rounded-full bg-[#ff896f]"></span>
                Personal collection
            </div>
            <h1
                class="font-['Space_Grotesk'] text-[clamp(2.25rem,5vw,4rem)] font-semibold leading-none tracking-[-.065em] text-[#f7f4ed]">
                {{ ucfirst($task->name) }}
                <span class="text-[#c7f36b]">.</span>
            </h1>
            <p class="mt-4 flex items-center gap-2 text-[12px] text-[#85899f]">
                <i class="fa-regular fa-calendar-check"></i>
                @if ($task->created_at)
                Created on {{ $task->created_at->format('d M, Y').' at '.$task->created_at->format('g:i A') }}
                @endif
                <span class="px-1 text-[#4f536b]">|</span>
                <i class="fa-solid fa-arrow-rotate-right fa-rotate-180"></i>
                @if ($task->updated_at)
                Updated on {{ $task->updated_at->format('d M, Y').' at '.$task->updated_at->format('g:i A') }}
                @else
                Updated just now
                @endif
            </p>
        </div>

        <div class="flex items-center gap-3 sm:pb-1">
            <button
                class="pressable p-2 text-amber-400 hover:text-amber-300 bg-[#162030] hover:bg-[#1E2A3F] border border-[#25334A] rounded-xl transition-colors"
                title="Favorite task">
                <svg class="w-4 h-4 fill-amber-400 stroke-amber-400" viewbox="0 0 24 24">
                    <path
                        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                </svg>
            </button>
            <button
                class="pressable px-3 py-2 text-xs font-medium text-slate-300 hover:text-white bg-[#162030] hover:bg-[#1E2A3F] border border-[#25334A] rounded-xl flex items-center gap-1.5 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                    <path
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Edit</span>
            </button>
            <button
                class="pressable p-2 text-slate-400 hover:text-rose-400 bg-[#162030] hover:bg-rose-950/30 border border-[#25334A] hover:border-rose-900/60 rounded-xl transition-colors"
                title="Delete task">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                    <path
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
                </svg>
            </button>
            <div class="hidden h-10 w-px bg-[#303249] sm:block"></div>

            <div x-data="{ optionsDropdown: false }" class="relative">
                <button type="button" x-on:click="optionsDropdown = !optionsDropdown" class="tn-icon-button"
                    :aria-expanded="optionsDropdown" aria-label="List options">
                    <i class="fa-solid fa-ellipsis text-[14px]"></i>
                </button>

                <div x-show="optionsDropdown" x-on:click.outside="optionsDropdown = false"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute right-0 top-11 z-10 min-w-[13rem] overflow-hidden rounded-[0.85rem] border border-[#383a50] bg-[#222438] shadow-[0_18px_40px_rgb(4_5_10_/_0.35)]"
                    style="display: none">
                    <button type="button" wire:click="deleteList"
                        wire:confirm="Are you sure you want to delete this list?" x-on:click="optionsDropdown = false"
                        class="flex w-full items-center gap-2.5 px-3.5 py-[0.7rem] text-left text-xs text-[#c4c5ce] transition-colors duration-[180ms] motion-reduce:transition-none hover:bg-[#303249] hover:text-[#ff896f]">
                        <i class="fa-solid fa-trash-can text-[11px]"></i>
                        Delete list
                    </button>
                    <button type="button" wire:click="$dispatch('open-edit-list-modal')"
                        x-on:click="optionsDropdown = false"
                        class="flex w-full items-center gap-2.5 px-3.5 py-[0.7rem] text-left text-xs text-[#c4c5ce] transition-colors duration-[180ms] motion-reduce:transition-none hover:bg-[#303249] hover:text-[#f5f4ef]">
                        <i class="fa-solid fa-pen text-[11px]"></i>
                        Rename list
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-8 space-y-3">
            <div class="relative overflow-hidden rounded-2xl border border-[#34364c] bg-[#1d1f2e] p-5">
                <div class="relative">
                    <div class="mb-2 flex items-center justify-between">
                        <span class="flex items-center gap-2 text-[11px] font-medium text-gray-400">
                            <i class="fa-solid fa-wand-magic-sparkles text-[#c7f36b]"></i>
                            Task pulse
                        </span>
                    </div>
                    <div class="mt-2">
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-extrabold text-white tracking-tight">60</span>
                            <span class="text-sm font-semibold text-gray-400">%</span>
                        </div>
                        <p class="text-xs text-gray-400 font-medium mt-0.5">3 of 5 subtasks completed</p>
                    </div>
                    <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-[#303249]">
                        <div class="h-full rounded-full bg-[#c7f36b] transition-all duration-500" style="width: 60%">
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative overflow-hidden rounded-2xl border border-[#34364c] bg-[#1d1f2e] p-5">
                <div class="relative">
                    <div class="mb-2 flex items-center justify-between">
                        <span class="flex items-center gap-2 text-[11px] font-medium text-gray-400">
                            <i class="fa-solid fa-align-left text-[#81c7ff]"></i>
                            Description
                        </span>
                    </div>
                    @if($task->details)
                    <div
                        class="mt-2 h-[110px] overflow-y-auto custom-scrollbar">
                        <p class="text-[13px] leading-relaxed text-gray-400 font-medium">{{ $task->details }}</p>
                    </div>
                    @else
                    <div
                        class="mt-2 h-[110px] rounded-xl border border-dashed border-[#454860] bg-[#171925]/60 px-4 py-3.5 text-[13px] text-[#666b85] cursor-text transition-colors hover:border-[#5a5e7d]">
                        No description yet — click to add one.
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- ==================== RIGHT / METADATA COLUMN ==================== -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Properties Card -->
            <section class="bg-[#1d1f2e] text-[#85899f] rounded-2xl border border-[#34364c] p-6 space-y-4"
                data-purpose="task-properties-drawer">
                <h2 class="text-xs font-semibold uppercase tracking-wider pb-2 border-b border-[#1E293B]">
                    Properties &amp; Meta
                </h2>
                <div class="space-y-3.5 text-sm md:text-[13px] text-gray-400">
                    <!-- Status -->
                    <div class="flex items-center justify-between py-1 border-b border-dotted border-[#1C2638]">
                        <span class="flex items-center gap-2 font-medium">
                            <i class="fa-solid fa-circle-info"></i>
                            Status
                        </span>
                        <span
                            class="px-2 py-1 rounded-full text-xs font-normal {{ $this->status['classes'] }}">
                            {{ $this->status['label'] }}
                        </span>
                    </div>
                    <!-- Priority -->
                    <div class="flex items-center justify-between py-1 border-b border-dotted border-[#1C2638]">
                        <span class="flex items-center gap-2 font-medium">
                            <i class="fa-regular fa-flag"></i>
                            Priority
                        </span>
                        @if ($task->priority && isset($this->priorityMeta[$task->priority]))
                        <span
                            class="font-normal text-xs flex items-center px-2 py-1 rounded-full {{ $this->priorityMeta[$task->priority]['classes'] }}">
                            {{ $this->priorityMeta[$task->priority]['label'] }}
                        </span>
                        @else
                        <span class="font-medium text-xs flex items-center py-1 text-gray-500">
                            Not set
                        </span>
                        @endif
                    </div>
                    <!-- Due Date -->
                    <div class="flex items-center justify-between py-1.5 border-b border-dotted border-[#1C2638]">
                        <span class="flex items-center gap-2 font-medium">
                            <i class="fa-regular fa-calendar-days"></i>
                            Deadline
                        </span>
                        <span class="font-normal text-slate-200">
                            @if ($task->due_at)
                            <span class="font-medium flex text-xs items-center py-1">
                                {{ $task->due_at->format('d M, Y g:i A') }}
                            </span>
                            @else
                            <span class="font-medium text-xs flex items-center py-1 text-gray-500">
                                No deadline
                            </span>
                            @endif
                        </span>
                    </div>

                    <!-- Scheduled at -->
                    <div class="flex items-center justify-between py-1.5 border-b border-dotted border-[#1C2638]">
                        <span class="flex items-center gap-2 font-medium">
                            <i class="fa-regular fa-calendar-check"></i>
                            Scheduled at
                        </span>
                        <span class="font-normal text-slate-200">
                            @if ($task->scheduled_at)
                            <span class="font-medium flex text-xs items-center py-1">
                                {{ $task->scheduled_at->format('d M, Y g:i A') }}
                            </span>
                            @else
                            <span class="font-medium text-xs flex items-center py-1 text-gray-500">
                                Not scheduled
                            </span>
                            @endif
                        </span>
                    </div>
                    <!-- List / Collection -->
                    <div class="flex items-center justify-between py-1 border-b border-dotted border-[#1C2638]">
                        <span class="flex items-center gap-2 font-medium">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                            List
                        </span>
                        <span
                            class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-normal bg-yellow-300/10 text-yellow-300 border border-yellow-300/20">
                            {{ $task->list->name }}
                        </span>
                    </div>
                </div>
            </section>
            <!-- Quick Action Buttons Box -->
            {{-- <section class="bg-[#151C28] rounded-2xl border border-[#222E42] p-5 space-y-3"
                data-purpose="quick-actions-card">
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider pb-1">Quick Actions
                </h2>
                <!-- Primary Complete Action Button (Lime Green #98E52A with dark text) -->
                <button
                    class="pressable w-full bg-[#98E52A] hover:bg-[#AAFA3E] active:bg-[#86D021] text-[#0A1205] font-extrabold text-sm py-3 px-4 rounded-xl flex items-center justify-center gap-2 shadow-[0_4px_16px_rgba(152,229,42,0.25)] transition-all"
                    type="button">
                    <svg class="w-5 h-5 stroke-[2.8]" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                        <path d="M4.5 12.75l6 6 9-13.5" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>
                    <span>Mark as Completed</span>
                </button>
                <!-- Secondary Actions: Reschedule & Duplicate -->
                <div class="grid grid-cols-2 gap-2 pt-1">
                    <button
                        class="pressable py-2 px-3 rounded-xl bg-[#1C2638] hover:bg-[#25334A] text-slate-300 hover:text-white text-xs font-semibold border border-[#26354B] flex items-center justify-center gap-1.5 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                            <path
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Reschedule</span>
                    </button>
                    <button
                        class="pressable py-2 px-3 rounded-xl bg-[#1C2638] hover:bg-[#25334A] text-slate-300 hover:text-white text-xs font-semibold border border-[#26354B] flex items-center justify-center gap-1.5 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                            <path
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Duplicate</span>
                    </button>
                </div>
            </section> --}}
        </div>
    </div>
</div>
