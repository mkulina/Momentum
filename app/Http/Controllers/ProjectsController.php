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
    $this->authorize('update', $project);

    return view('projects.show', compact('project'));
  }

  public function create() {
    return view('projects.create');
  }

  public function store(Project $project) {
    $project = request()->validate([
      'title' => 'sometimes|required',
      'description' => 'sometimes|required',
      'notes' => 'nullable'
      ]);

     $project = auth()->user()->projects()->create($project);

    return redirect($project->path());
  }

  public function edit(Project $project) {
    $this->authorize('update', $project);
    return view('projects.edit', compact('project'));
  }

  public function update(Project $project) {
    $this->authorize('update', $project);

    $attributes = request()->validate([
      'title' => 'sometimes|required',
      'description' => 'sometimes|required',
      'notes' => 'nullable'
      ]);

    $project->update($attributes);

    return redirect($project->path());
  }

}
