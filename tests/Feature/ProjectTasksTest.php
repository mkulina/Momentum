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

  public function test_a_task_can_be_updated() {
    $this->signIn();

    $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

    $task = $project->addTask('test task');

    $this->patch($project->path() . '/tasks/' . $task->id, [
      'body' => 'changed',
      'completed' => true
    ]);

    $this->assertDatabaseHas('tasks', [
      'body' => 'changed',
      'completed' => true
    ]);
  }

  public function test_a_task_requires_a_body() {
    $this->signIn();

    $project = auth()->user()->projects()->create(
      factory(Project::class)->raw()
    );

    $attributes = factory('App\Models\Task')->raw(['body' => '']);

    $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
  }

  public function test_only_the_owner_of_a_project_may_add_tasks() {
    $this->signIn();

    $project = factory('App\Models\Project')->create();

    $this->post($project->path() . '/tasks', ['body' => 'Test task'])->assertStatus(403);

    $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
  }

  public function test_only_the_owner_of_a_project_may_update_a_task() {
    $this->signIn();

    $project = factory('App\Models\Project')->create();

    $task = $project->addTask('Test task');

    $this->patch($task->path(), ['body' => 'changed'])->assertStatus(403);

    $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
  }
}
