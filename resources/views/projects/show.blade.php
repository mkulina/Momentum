@extends('layouts.app')

@section('content')

<header class="flex items-center mb-3 py-3">
    <div class="flex justify-between items-end w-full">
      <h4 class="text-grey text-sm no-underline font-normal">My Projects</h4>
      <button href="/projects/create" class="button">New Project</button>
    </div>
  </header>

  <main>
    <div>
      <div>
          <h4 class="text-grey text-sm no-underline font-normal">Tasks</h4>
      </div>
      <div></div>
    </div>
  </main>
    <h1>{{ $project->title }}</h1>
    <div>{{ $project->description }}</div>
    <a href="/projects">Go Back</a>
@endsection
