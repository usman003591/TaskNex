@props(['icon', 'title', 'subtitle'])

<div class="rounded-2xl border border-dashed border-[#3b3e55] px-6 py-4 text-center">
    <p class="mt-4 text-[13px] font-semibold text-[#f0eee7]">{{ $title }}</p>
    <p class="mt-1 text-[11px] text-[#7f849d]">{{ $subtitle }}</p>
    <div class="mx-auto mt-4 grid h-12 w-12 place-items-center rounded-2xl text-[#c7f36b]">
        <i class="{{ $icon }} text-3xl"></i>
    </div>
</div>
