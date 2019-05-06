<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\SetUp\ProjectFactory;

class TriggerActivityTest extends TestCase {
  use RefreshDatabase;

  public function test_creating_a_project() {
    $project = ProjectFactory::create();

    $this->assertCount(1, $project->activity);
    $this->assertEquals('created', $project->activity[0]->description);
  }

  public function test_updating_a_project() {
    $project = ProjectFactory::create();

    $project->update(['title' => 'Changed']);

    $this->assertCount(2, $project->activity);
    $this->assertEquals('updated', $project->activity->last()->description);
  }

  public function test_creating_a_task() {
    $project = ProjectFactory::create();

    $project->addTask('Some task');

    $this->assertCount(2, $project->activity);
    $this->assertEquals('created_task', $project->activity->last()->description);
  }

  public function test_completing_a_new_task() {
    $project = ProjectFactory::withTasks(1)->create();

    $this->actingAs($project->owner)
         ->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
          ]);

    $this->assertCount(3, $project->activity);
    $this->assertEquals('completed_task', $project->activity->last()->description);
  }

  public function test_marking_task_incomplete() {
    $project = ProjectFactory::withTasks(1)->create();

    $this->actingAs($project->owner)
          ->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
     ]);

    $this->assertCount(3, $project->activity);

    $this->actingAs($project->owner)
          ->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false
          ]);

    $project->refresh();

    $this->assertCount(4, $project->activity);

    $this->assertEquals('marked_task_incomplete', $project->activity->last()->description);
  }

  public function test_deleting_a_task() {
    $project = ProjectFactory::withTasks(1)->create();

    $project->tasks[0]->delete();

    $this->assertCount(3, $project->activity);
  }
}
