@props([
    'align' => 'right',      // 'left' or 'right' — horizontal anchor
    'position' => 'bottom',   // 'bottom' (opens downward) or 'top' (opens upward)
    'width' => 'w-52',        // Tailwind width class
    'triggerClass' => '',     // Extra classes on the wrapper
    'id' => null,             // Optional unique id
])

@php
    $positionClasses = match ($position) {
        'top'    => 'bottom-11',
        default  => 'top-11',
    };

    $alignClasses = match ($align) {
        'left'   => 'left-0',
        default  => 'right-0',
    };

    $panelClasses = "absolute {$alignClasses} {$positionClasses} z-40 {$width} max-w-[calc(100vw-2rem)] overflow-hidden rounded-xl border border-[#383a50] bg-[#222438] shadow-[0_18px_40px_rgb(4_5_10/0.35)]";
@endphp

<div x-data="{ open: false }" class="relative {{ $triggerClass }}" @if($id) id="{{ $id }}" @endif>
    {{-- Trigger --}}
    <div x-on:click="open = !open">
        {{ $trigger }}
    </div>

    {{-- Panel --}}
    <div x-show="open"
        x-on:click.outside="open = false"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 {{ $position === 'top' ? 'translate-y-1' : '-translate-y-1' }}"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 {{ $position === 'top' ? 'translate-y-1' : '-translate-y-1' }}"
        class="{{ $panelClasses }}"
        style="display: none">
        <div x-on:click="open = false">
            {{ $slot }}
        </div>
    </div>
</div>
