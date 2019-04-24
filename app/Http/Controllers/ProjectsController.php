<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller {
  public function index() {
    $projects = Project::all();
    return view('projects.index', compact('projects'));
  }

  public function show(Project $project) {
    return view('projects.show', compact('project'));
  }

  public function store() {
    $project = request()->validate([
      'title' => 'required',
      'description' => 'required'
      ]);

      $project['owner_id'] = auth()->id();

    Project::create($project);

    return redirect('/projects');
  }
}
