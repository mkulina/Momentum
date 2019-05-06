<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Activity;

class ProjectObserver {
  public function created(Project $project) {
    $project->recordActivity('created');
  }

  public function updated(Project $project) {
    $project->recordActivity('updated');
  }
}
