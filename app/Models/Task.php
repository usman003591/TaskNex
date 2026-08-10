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

    //relationships
    public function list(){
        return $this->belongsTo(TaskList::class, 'list_id');
    }
}
