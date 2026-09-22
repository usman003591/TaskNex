<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskCollection extends Model
{
    use SoftDeletes;
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
        return $this->hasMany(Task::class, 'collection_id');
    }
}
