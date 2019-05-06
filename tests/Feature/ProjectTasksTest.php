<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Facades\Tests\SetUp\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase {
  use RefreshDatabase;

  public function test_a_project_can_have_tasks() {
    $this->withoutExceptionHandling();

    $this->signIn();

    $project = ProjectFactory::create();

    $this->actingAs($project->owner)
        ->post($project->path() . '/tasks', ['body' => 'Test task']);

    $this->get($project->path())
         ->assertSee('Test task');
  }

  public function test_a_task_can_be_updated() {
    $project = ProjectFactory::withTasks(1)->create();

    $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(), [
      'body' => 'changed'
    ]);

    $this->assertDatabaseHas('tasks', [
      'body' => 'changed'
    ]);
  }

  public function test_a_task_can_be_completed() {
    $project = ProjectFactory::withTasks(1)->create();

    $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(), [
      'body' => 'changed',
      'completed' => true
    ]);

    $this->assertDatabaseHas('tasks', [
      'body' => 'changed',
      'completed' => true
    ]);
  }

  public function test_a_task_can_be_marked_as_incomplete() {
    $project = ProjectFactory::withTasks(1)->create();

    $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(), [
      'body' => 'changed',
      'completed' => true
    ]);

    $this->patch($project->tasks[0]->path(), [
        'body' => 'changed',
        'completed' => false
      ]);

    $this->assertDatabaseHas('tasks', [
      'body' => 'changed',
      'completed' => false
    ]);
  }

  public function test_a_task_requires_a_body() {
    $this->signIn();

    $project = ProjectFactory::create();

    $attributes = factory('App\Models\Task')->raw(['body' => '']);

    $this->actingAs($project->owner)
        ->post($project->path() . '/tasks', $attributes)
        ->assertSessionHasErrors('body');
  }

  public function test_only_the_owner_of_a_project_may_add_tasks() {
    $this->signIn();

    $project = ProjectFactory::create();

    $this->post($project->path() . '/tasks', ['body' => 'Test task'])->assertStatus(403);

    $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
  }

  public function test_only_the_owner_of_a_project_may_update_a_task() {
    $this->signIn();

    $project = ProjectFactory::withTasks(1)->create();

    $this->patch($project->tasks[0]->path(), ['body' => 'changed'])->assertStatus(403);

    $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
  }
}
