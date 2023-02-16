@extends('frontend.layouts.app')

@section('title', 'Genre List')

@section('custom_style')
<style>
    .genre-item{
        color: #fff;
    }
    .genre-item p{
        padding: 5px;
        background: #000;
    }
</style>
@endsection

@section('content')

<section>
    <div class="container">
        <div class="genre-list">
            <div class="row">
                @foreach ($genres as $genre)
                <div class="col-md-3 my-4">
                    <div class="card text-center">
                        <div class="card-body genre-item py-5" style="background: url('{{ asset('genre_images/'.$genre->image) }}'); background-position: center; background-size: cover; background-repeat: no-repeat;"><p class="m-0">{{ $genre->name }}</p></div>
                        <div class="card-footer">
                            <a href="{{ route('genres.show', $genre->id) }}" class="btn btn-primary primary-btn">Check <i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
