@extends('dashboard.layouts.app')

@section('title', 'Crete New Genres')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (Session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif
            <div class="card p-3">
                <form action="{{ route('genres.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Enter Genres</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus>
                        @error('name')
                            <small><span class="text-danger">* {{ $message }}</span></small><br>
                        @enderror
                        <small>* You can create multiple genres. Enter comma between each genres.</small>
                    </div>

                    <div class="form-group mb-3">
                        <button class="btn btn-primary" type="submit">Add Genres <i class="fa fa-plus"></i></button>
                        <a href="{{ route('genres.index') }}" class="btn btn-danger">Cancle</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
