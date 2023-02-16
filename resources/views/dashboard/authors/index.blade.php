@extends('dashboard.layouts.app')

@section('title', 'Author List')

@section('custom_style')
<style>
    .author-img img{
        width: 100px;
        height: 100px;
        object-fit: contain;
    }
</style>
@endsection

@section('content')
<div class="container">
    <a href="{{ route('authors.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add New Author</a>
    <div class="table-responsive">
        @if (Session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif
        <table class="table border no-wrap">
            <thead>
                <tr>
                    <th class="border-top-0">#</th>
                    <th class="border-top-0">Profile</th>
                    <th class="border-top-0">Name</th>
                    <th class="border-top-0">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($authors as $author)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td class="author-img"><img src="{{ asset('profiles/'.$author->profile) }}" alt="" class="img-fluid"></td>
                    <td class="txt-oflo">{{ $author->name }}</td>
                    <td class="txt-ofo">
                        <a href="{{ route('authors.show', $author->id) }}" class="btn btn-sm btn-success">Detail <i class="fa fa-user-cog"></i></a>
                        <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-sm btn-success">Edit <i class="fa fa-user-pen"></i></a>
                        <form action="{{ route('authors.destroy', $author->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Are you sure to want to delete?')" class="btn btn-sm btn-danger">Delete <i class="fa fa-user-xmark pr-3"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $authors->links() }}
    </div>
</div>

@endsection
