@extends('frontend.layouts.app')

@section('title', 'Genre Books List')

@section('custom_style')

@endsection

@section('content')

<section>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="title">Related Book List</h3>
            <a href="{{ route('genres.index') }}" class="btn btn-primary primary-btn">Genre List</a>
        </div>
        <hr>
        <div class="books">
            <div class="row">
                @foreach ($genre->books as $book)
                <div class="book-card col-md-4">
                    <div class="card p-3 border-0">
                        <img src="{{ asset('covers/'.$book->cover) }}" alt="" class="book-cover">
                        <hr>
                        <h3 class="book-title text-center"><a href="{{ route('books.show', $book) }}">{{ $book->name }}</a></h3>
                        <p class="book-genre text-center mt-3">By : <a href="{{ route('authors.show', $book->author_id) }}">{{ $book->author->name }}</a></p>
                        <a href="{{ route('books.show', $book) }}" class="btn btn-primary primary-btn">Read More</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
