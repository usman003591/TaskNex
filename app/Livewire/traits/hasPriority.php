<?php

namespace App\Livewire\traits;
use Livewire\Attributes\Computed;

trait hasPriority
{
    #[Computed]
    public function priorityMeta(): array
    {
        return [
            1 => [
                'label' => 'Urgent',
                'classes' => 'bg-red-500/10 text-red-400 border border-rose-500/20'
            ],
            2 => [
                'label' => 'Medium',
                'classes' => 'bg-amber-500/10 text-amber-500 border border-amber-500/20'
            ],
            3 => [
                'label' => 'Low',
                'classes' => 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20'
            ],
        ];
    }
}
