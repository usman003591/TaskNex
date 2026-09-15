<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class priorityBadge extends Component
{
    protected const META = [
        1 => [
            "label" => "Urgent",
            "classes" => "bg-red-500/10 text-red-400 border border-rose-500/20",
        ],
        2 => [
            "label" => "Medium",
            "classes" =>
                "bg-amber-500/10 text-amber-500 border border-amber-500/20",
        ],
        3 => [
            "label" => "Low",
            "classes" =>
                "bg-emerald-500/10 text-emerald-500 border border-emerald-500/20",
        ],
    ];

    public ?array $meta;
    /**
     * Create a new component instance.
     */
    public function __construct(public ?int $priority = null)
    {
        $this->meta = self::META[$priority] ?? null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view("components.priority-badge");
    }
}
