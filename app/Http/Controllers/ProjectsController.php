<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller {
  public function index() {
    $projects = auth()->user()->projects;
    return view('projects.index', compact('projects'));
  }

  public function show(Project $project) {
    if (auth()->id() != $project->owner_id) {
      abort(403);
    }

    return view('projects.show', compact('project'));
  }

  public function store(Project $project) {
    $project = request()->validate([
      'title' => 'required',
      'description' => 'required'
      ]);

     auth()->user()->projects()->create($project);

    return redirect('/projects');
  }
}
