<?php

namespace App\Models;

use App\Models\TaskList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'list_id',
        'details',
        'starred',
        'is_completed',
        'priority',
        'scheduled_at',
        'due_at'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'due_at' => 'datetime',
    ];

    //relationships
    public function list()
    {
        return $this->belongsTo(TaskList::class, 'list_id');
    }

    public function getDueStatusAttribute(): ?array
    {
        if (!$this->due_at) {
            return null;
        }

        if ($this->due_at->isPast()) {
            return ['label' => 'Overdue ' . $this->due_at->diffForHumans(), 'color' => 'text-red-400/80'];
        }

        if ($this->due_at->isToday()) {
            return ['label' => 'Due ' . $this->due_at->diffForHumans(), 'color' => 'text-amber-400/80'];
        }

        if ($this->due_at->isTomorrow()) {
            return ['label' => 'Due Tomorrow ' . $this->due_at->format('g:i A'), 'color' => 'text-green-300/70'];
        }

        return ['label' => 'Due ' . $this->due_at->format('j M Y, g:i A'), 'color' => 'text-green-300/70'];
    }
}
