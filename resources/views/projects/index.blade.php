<!DOCTYPE html>
<html>
  <head>
    <title></title>
  </head>
  <body>
    <h1>Momentum</h1>

    <ul>
      @forelse ($projects as $project)
        <li><a href="{{ $project->path() }}">{{ $project->title }}</a></li>

      @empty
        No Projects Yet
      @endforelse
    </ul>
  </body>
</html>
