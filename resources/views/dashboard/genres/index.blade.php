@extends('dashboard.layouts.app')

@section('title', 'Genres List')

@section('content')
<div class="container">
    <a href="{{ route('genres.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add New Genres</a>
    <div class="genres">
        @if (Session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif
        <div class="genre-list">
            <div class="row">
                @foreach ($genres as $genre)
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">{{ $genre->name }}</div>
                        <div class="card-footer">
                            <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-sm btn-success">Edit <i class="fa fa-edit"></i></a>
                        <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Are you sure to want to delete?')" class="btn btn-sm btn-danger">Delete <i class="fa fa-trash pr-3"></i></button>
                        </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{ $genres->links() }}
    </div>
</div>
@endsection
