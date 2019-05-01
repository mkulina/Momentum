<?php

namespace Tests\SetUp;

use App\User;
use App\Models\Task;
use App\Models\Project;

class ProjectFactory {

  protected $tasksCount = 0;

  protected $user;

  public function ownedBy($user) {
    $this->user = $user;

    return $this;
  }

  public function withTasks($count) {
    $this->tasksCount = $count;

    return $this;
  }

  public function create() {
    $project = factory(Project::class)->create([
      'owner_id' => $this->user ?? factory(User::class),
    ]);

    factory(Task::class, $this->tasksCount)->create([
      'project_id' => $project->id,
    ]);

    return $project;
  }
}
