@if ($meta)
    <span
        class="hidden rounded-full border {{ $meta['classes'] }} px-2 py-1 text-[11px] font-medium tracking-[0.015rem] sm:inline-flex">
        {{ $meta['label'] }}
    </span>
@endif
