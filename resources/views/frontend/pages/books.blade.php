@extends('frontend.layouts.app')

@section('title', 'Book Library')

@section('custom_style')
<style>

.home-img{
    max-height: 300px;
    object-fit: contain;
}
.author{
    font-family: bodyRegularFont;
    letter-spacing: 3px;
    text-transform: uppercase;
}

</style>
@endsection

@section('content')

<!-- Home -->
<section class="home text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <h6 class="author"><a href="{{ route('authors.show', $latestBook->author->id) }}">author: {{ $latestBook->author->name }}</a></h6>
                <h1 class="title display-5 my-2">{{ $latestBook->name }}</h1>
                <p class="description">
                    {{ $latestBook->excerpt }}
                </p>
                <a href="{{ route('books.show', $latestBook) }}" class="btn btn-primary primary-btn">
                    Read Now
                </a>
            </div>
            <div class="col-md-5 col-sm-12">
                <img src="{{ asset('covers/'.$latestBook->cover) }}" class="img-fluid w-100 home-img" alt="Book" />
            </div>
        </div>
    </div>
</section>
<hr>
<section>
    <div class="container text-center">
        <h1 class="display-2 mb-4">
            <i class="fa fa-running"></i> coming soon <i class="fa fa-running"></i>
        </h1>
        <p class="text-danger">This page is under construction!</p>
    </div>
</section>

@endsection
