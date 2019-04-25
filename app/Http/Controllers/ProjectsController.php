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
    return view('projects.show', compact('project'));
  }

  public function store() {
    $project = request()->validate([
      'title' => 'required',
      'description' => 'required'
      ]);

     auth()->user()->projects()->create($project);

    return redirect('/projects');
  }
}
