<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase {
  use RefreshDatabase;

  public function test_a_user_has_projects() {
    $user = factory('App\User')->create();
    $this->assertInstanceOf(Collection::class, $user->projects);
  }
}
