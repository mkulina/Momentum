<?php

namespace Tests\Feature;

use App\Models\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase {
  use RefreshDatabase;

  public function test_a_project_can_have_tasks() {
    $this->withoutExceptionHandling();
    $this->signIn();

    $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

    $this->post($project->path() . '/tasks', ['body' => 'Test task']);

    $this->get($project->path())
         ->assertSee('Test task');
  }
}
