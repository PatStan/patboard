<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'completed', 'project_id'];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($task){
            $task->project->recordActivity('created task');
        });
    }

    public function complete()
    {
        $this->update(['completed' => true]);
        $this->project->recordActivity('completed task');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }
}
