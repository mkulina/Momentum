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
        {{-- tasks --}}
        <div class="card mb-3">Lorem imsum.</div>
        <div class="card mb-3">Lorem imsum.</div>
        <div class="card mb-3">Lorem imsum.</div>
        <div class="card">Lorem imsum.</div>
      </div>
      <div class="mb-8">
        <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
        {{-- general notes --}}
        <textarea class="card w-full" style="min-height: 200px">Lorem imsum.</textarea>
      </div>
    </div>
    <div class="lg:w-1/4 px-3">
      @include ('projects.card')
    </div>
  </div>
</main>

@endsection
