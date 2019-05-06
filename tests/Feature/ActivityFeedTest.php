<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\SetUp\ProjectFactory;

class ActivityFeedTest extends TestCase {
  use RefreshDatabase;

  public function test_creating_a_project_generates_activity() {
    $project = ProjectFactory::create();

    $this->assertCount(1, $project->activity);
  }
}
