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

    $this->assertEquals('projects/' . $project->id, $project->path());
  }
}
