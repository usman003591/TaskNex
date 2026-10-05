@props([
    'icon' => null,          // Font Awesome icon class, e.g. 'fa-solid fa-pen'
    'hoverColor' => 'hover:text-text-primary',  // Tailwind hover text color
])

<button type="button" {{ $attributes->merge([
    'class' => "flex w-full items-center gap-2.5 px-3.5 py-[0.65rem] text-left text-xs text-[#c4c5ce] transition-colors duration-180 motion-reduce:transition-none hover:bg-[#303249] {$hoverColor} cursor-pointer",
]) }}>
    @if($icon)
        <i class="{{ $icon }} text-[11px]"></i>
    @endif
    {{ $slot }}
</button>
