@extends('layouts.app')

@section('content')

<header class="flex items-center mb-3 py-3">
  <div class="flex justify-between items-end w-full">
    <p class="text-grey text-sm no-underline font-normal">
      <a class="text-grey text-sm no-underline font-normal" href="/projects">My Projects</a> / {{ $project->title }}
    </p>
    <button href="/projects/create" class="button">New Project</button>
  </div>
</header>

<main>
  <div class="lg:flex -mx-3">
    <div class="lg:w-3/4 px-3">
      <div class="mb-8">
        <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>
        @foreach ($project->tasks as $task)
          <div class="card mb-3">
          <form method="POST" action="{{ $task->path() }}">
              @method('PATCH')
              @csrf
                <div class="flex">
                  <input name="body" class="w-full" value="{{ $task->body }}" {{ $task->completed ? 'text-grey' : ''}}>
                  <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                </div>
            </form>
          </div>
        @endforeach
        <div class="card mb-3">
          <form action="{{$project->path() . '/tasks'}}" method="POST">
            @csrf
              <input placeholder="Add a new task" class="w-full" name="body">
          </form>
        </div>

      </div>
      <div class="mb-8">
        <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
        <form method="POST" action=" {{ $project->path() }}">
          @method('PATCH')
          @csrf
            <textarea class="card w-full mb-3" style="min-height: 200px" placeholder="Anything to take note of?" name="notes">{{ $project->notes}}</textarea>
            <button type="submit" class="button float-right">Save</button>
        </form>
      </div>
    </div>
    <div class="lg:w-1/4 px-3">
      @include ('projects.card')
    </div>
  </div>
</main>

@endsection
