@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" class="mt-5 d-flex flex-column justify-content-space-between gap-3 col-6 m-auto">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title" class="mb-1">Titolo</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $project->title }}" required>
        </div>
        <div class="form-group">
            <label for="github" class="mb-1">GitHub</label>
            <input type="text" name="github" id="github" class="form-control" value="{{ $project->github }}" required>
        </div>
        <div class="form-group">
            <label for="link" class="mb-1">Link</label>
            <input type="text" name="link" id="link" class="form-control" value="{{ $project->link }}">
        </div>
        <div class="form-group">
            <label for="languages" class="mb-1">Linguaggi</label>
            <input type="text" name="languages" id="languages" class="form-control" value="{{ $project->languages }}" required>
        </div>
        <button type="submit" class="btn btn-primary col-2">Aggiorna</button>
    </form>
</div>
@endsection
