<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = [
      'completed' => 'boolean'
    ];

    public function project() {
      return $this->belongsTo(Project::class);
    }

    public function path() {
      return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function complete() {
      $this->update(['completed' => true]);
      $this->project->recordActivity('completed_task');
    }

    public function incomplete() {
      $this->update(['completed' => false]);
      $this->project->recordActivity('marked_task_incomplete');
    }
}
