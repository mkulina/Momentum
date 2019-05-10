<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver {

  public function created(Task $task) {
    $task->recordActivity('created_task');
  }

  public function deleted(Task $task) {
    $task->project->recordActivity('deleted_task');
  }

  public function activity() {
    return $this->morphMany(Activity::class, 'subject')->latest();
  }

  public function recordActivity($description) {
    $this->activity()->create([
      'project_id' => $this->project_id,
      'description' => $description
      ]);
  }
}
