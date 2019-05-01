@extends ('layouts.app')

@section('content')
    <form method="POST" action="/projects" class="lg:w-1/2 lg:mx-auto bg-white py-12 px-16 rounded shadow">
        @csrf

        <h1 class="text-2xl font-normal mb-10 text-center">Create a new project</h1>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="title">Title</label>

            <div class="control">
                <input type="text" class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full" name="title" placeholder="Title">
            </div>
        </div>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="description">Description</label>

            <div class="control">
                <textarea name="description" rows="10" class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full" placeholder="Description"></textarea>
            </div>
        </div>

        <div class="field">
            <div class="control flex justify-between">
                <a class="button-outline-dark" href="/projects">Cancel</a>
                <button type="submit" class="button is-link mr-2">Create Project</button>
            </div>
        </div>
    </form>
@endsection
