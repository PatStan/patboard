<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'notes']; //removed user_id as fillable here, if problems encountered try re-adding it

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function recordActivity($type)
    {
        Activity::create([
            'project_id' => $this->id,
            'description' => $type
        ]);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(['body' => $body]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
