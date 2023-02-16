@extends('dashboard.layouts.app')

@section('title', 'Edit Author Info')

@section('content')
<div class="container">
    <div class="form-group w-50 mx-auto my-5">
        @if (Session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif
        <div class="card p-3">
            <form action="{{ route('authors.update', $author->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Author Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $author->name) }}" autofocus>
                    @error('name')
                        <small><span class="text-danger">* {{ $message }}</span></small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="biography" class="form-label">Author Biography</label>
                    <textarea name="biography" id="biography" class="form-control @error('biography') is-invalid @enderror">{{ old('biography', $author->biography) }}</textarea>
                    @error('biography')
                        <small><span class="text-danger">* {{ $message }}</span></small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <input type="file" name="profile" id="" class="form-control @error('profile') is-invalid @enderror">
                    <div class="d-flex justify-content-between align-items-center my-3">
                        <h3>Old Image => </h3>
                        <img src="{{ asset('profiles/'.$author->profile) }}" alt="" class="img-fluid rounded" width="200" height="200">
                    </div>
                    @error('profile')
                        <small><span class="text-danger">* {{ $message }}</span></small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <button class="btn btn-primary" type="submit">Update Author <i class="fa fa-plus"></i></button>
                    <a href="{{ route('authors.list') }}" class="btn btn-danger">Cancle</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
