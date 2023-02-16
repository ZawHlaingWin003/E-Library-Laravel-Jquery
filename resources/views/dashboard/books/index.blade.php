@extends('dashboard.layouts.app')

@section('title', 'Book List')

@section('content')
<div class="container">
    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add New Book</a>
    @if (session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <div class="table-responsive">
        <table class="table no-wrap">
            <thead>
                <tr>
                    <th class="border-top-0">#</th>
                    <th class="border-top-0">Name</th>
                    <th class="border-top-0">Author</th>
                    <th class="border-top-0">Genres</th>
                    <th class="border-top-0">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td class="txt-oflo">{{ $book->name }}</td>
                    <td class="txt-oflo">{{ $book->author->name }}</td>
                    <td class="txt-oflo">@foreach ($book->genres as $genre)
                        <span class="badge bg-primary">{{ $genre->name }}</span>
                    @endforeach</td>
                    <td class="txt-ofo">
                        <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-success">Detail <i class="fa fa-user-cog"></i></a>
                        <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-success">Edit <i class="fa fa-user-pen"></i></a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Are you sure to want to delete?')" class="btn btn-sm btn-danger">Delete <i class="fa fa-user-xmark pr-3"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $books->links() }}
    </div>
</div>
@endsection
