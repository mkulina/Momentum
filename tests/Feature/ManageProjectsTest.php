<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase {
  use WithFaker, RefreshDatabase;

  public function test_guests_cannot_control_projects() {

    $newProject = factory('App\Models\Project')->create();

    $this->post('/projects', $newProject->toArray())->assertRedirect('login');
    $this->get('/projects')->assertRedirect('login');
    $this->get('projects/create')->assertRedirect('login');
    $this->get($newProject->path())->assertRedirect('login');
  }

  public function test_a_user_can_create_a_project() {
    $this->withoutExceptionHandling();

    $this->signIn();

    $this->get('/projects/create')->assertStatus(200);

    $attributes = [
      'title' => $this->faker->sentence,
      'description' => $this->faker->sentence,
      'notes' => 'General notes here.'
    ];
    $response = $this->post('/projects', $attributes);

    $project = Project::where($attributes)->first();

    $response->assertRedirect($project->path());

    $this->assertDatabaseHas('projects', $attributes);

    $this->get($project->path())
        ->assertSee($attributes['title'])
        ->assertSee($attributes['description'])
        ->assertSee($attributes['notes']);
  }

  public function test_a_user_can_view_their_project() {
     $this->withoutExceptionHandling();

     $this->signIn();

    $project = factory('App\Models\Project')->create(['owner_id' => auth()->id()]);

    $this->get($project->path())
          ->assertSee($project->title)
          ->assertSee($project->description);
  }

  public function test_a_user_can_update_their_project() {
    $this->withoutExceptionHandling();

    $this->signIn();

    $project = factory('App\Models\Project')->create(['owner_id' => auth()->id()]);

    $this->patch($project->path(), [
      'notes' => 'Changed'
    ])->assertRedirect($project->path());

    $this->assertDatabaseHas('projects', [
      'notes' => 'Changed'
      ]);

  }

  public function test_an_authenticated_user_cannot_view_the_projects_of_others() {
    $this->signIn();

    // $this->withoutExceptionHandling();

    $project = factory('App\Models\Project')->create();

    $this->get($project->path())->assertStatus(403);
  }

  public function test_an_authenticated_user_cannot_update_the_projects_of_others() {
    $this->signIn();

    // $this->withoutExceptionHandling();

    $project = factory('App\Models\Project')->create();

    $this->patch($project->path(), [])->assertStatus(403);
  }

  public function test_a_project_requires_a_title() {
    $this->signIn();

    $attributes = factory('App\Models\Project')->raw(['title' => '']);

    $this->post('/projects', $attributes)->assertSessionHasErrors('title');
  }

  public function test_a_project_requires_a_description() {
    $this->signIn();

    $attributes = factory('App\Models\Project')->raw(['description' => '']);

    $this->post('/projects', $attributes)->assertSessionHasErrors('description');
  }

  public function test_it_belongs_to_an_owner() {
  $this->withoutExceptionHandling();

  $project = factory('App\Models\Project')->create();

  $this->assertInstanceOf('App\User', $project->owner);
  }
}
