<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskList extends Model
{
    use SoftDeletes;
    protected $table = 'lists';

    protected $fillable = [
        'name',
        'user_id',
        'is_default',
    ];

    //Relationships
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'list_id');
    }
}

