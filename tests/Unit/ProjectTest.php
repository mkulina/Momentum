<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase {
  use RefreshDatabase;
  public function test_it_has_a_path() {
    $project = factory('App\Models\Project')->create();

    $project->path();

    $this->assertEquals('/projects/' . $project->id, $project->path());
  }

  public function test_it_can_add_a_task() {
    $project = factory('App\Models\Project')->create();

    $task = $project->addTask('Test task');

    $this->assertCount(1, $project->tasks);
    $this->assertTrue($project->tasks->contains($task));
  }
}
