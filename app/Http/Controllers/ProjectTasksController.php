<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectTasksController extends Controller
{
    public function store(Project $project) {
      if (auth()->user()->isNot($project->owner)) {
        abort(403);
      }

      request()->validate(['body' => 'required']);

      $project->addTask(request('body'));

      return redirect($project->path());
    }

    public function update(Project $project, Task $task) {
      if (auth()->user()->isNot($project->owner)) {
        abort(403);
      }

      request()->validate(['body' => 'required']);

      $task->update([
        'body' => request('body'),
        'completed' => request()->has('completed')
      ]);

      return redirect($project->path());
    }
}
