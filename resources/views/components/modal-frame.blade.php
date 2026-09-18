@props([
    'open' => false,
    'title' => '',
    'description' => null,
    'icon' => 'fa-solid fa-info',
    'closeMethod' => 'closeModal()',
])
<div>
    @if($open)
    <div x-data="{ show: false }" x-init="$nextTick(() => {
                show = true;
                requestAnimationFrame(() => requestAnimationFrame(() => $refs.nameInput.focus()));
            })" x-on:keydown.escape.window="show = false; setTimeout(() => $wire.{{ $closeMethod }}, 300)"
        class="fixed inset-0 z-50 font-['DM_Sans',ui-sans-serif,system-ui,sans-serif]">
        {{-- Backdrop --}}
        <div x-show="show" x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-on:click="show = false; setTimeout(() => $wire.{{ $closeMethod }}, 300)"
            class="absolute inset-0 bg-[#0b0c13]/75 backdrop-blur-md" aria-hidden="true"></div>

        {{-- Dialog --}}
        <div class="absolute inset-0 flex items-center justify-center overflow-y-auto p-4 sm:p-6">
            <div x-show="show" x-transition:enter="transition-all ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 scale-[.98]"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition-all ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 scale-[.98]"
                class="relative my-auto w-full max-w-lg overflow-visible bg-[#1c1d2b] border border-[#454860] rounded-xl"
                role="dialog" aria-modal="true" aria-labelledby="create-task-title">
                <div class="px-5 pb-7 pt-5 sm:px-6 sm:pt-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div
                                class="grid mt-1 h-10 w-10 shrink-0 place-items-center rounded-xl bg-accent/10 text-accent">
                                <i class="{{ $icon }}"></i>
                            </div>
                            <div>
                                <h2 id="create-task-title"
                                    class="text-xl font-semibold text-text-primary font-['Space_Grotesk',ui-sans-serif,system-ui,sans-serif] tracking-[-0.04em]">
                                    {{ $title }}
                                </h2>
                                @if ($description)
                                <p class="mt-1 text-[11px] text-[#85899f]">
                                    {{ $description }}
                                </p>
                                @endif
                            </div>
                        </div>

                        <button type="button" x-on:click="show = false; setTimeout(() => $wire.{{ $closeMethod }}, 300)"
                            aria-label="Close create task dialog" class="tn-icon-button cursor-pointer">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
    @endif
</div>
