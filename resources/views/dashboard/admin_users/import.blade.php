@extends('dashboard.layouts.app')

@section('title', 'Import Excel File')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-5">
            <div class="card p-3">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <small><p class="alert alert-danger">* {{ $error }}</p></small>
                    @endforeach
                @endif
                <form action="{{ route('admin_users.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <input type="file" name="admin_users" id="" class="form-control @error('admin_users') is-invalid @enderror">
                    </div>

                    <button type="submit" class="btn btn-primary my-3">Import Excel</button>
                    <a href="{{ route('admin_users.index') }}" class="btn btn-danger my-3">Cancle</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
