@extends('dashboard.layouts.app')

@section('title', 'Add New Book')

@section('content')
<div class="container">
    <div class="form-group w-75 mx-auto my-5">
        @if (Session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif
        <div class="card p-3">
            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <div class="form-group mb-4">
                    <label for="name" class="form-label">Book Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus>
                    @error('name')
                        <small><span class="text-danger">* {{ $message }}</span></small>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="slug" class="form-label">Book Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" autofocus>
                    @error('slug')
                        <small><span class="text-danger">* {{ $message }}</span></small>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="excerpt" class="form-label">Book Excerpt</label>
                    <textarea name="excerpt" id="excerpt" class="form-control @error('excerpt') is-invalid @enderror">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <small><span class="text-danger">* {{ $message }}</span></small>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="genre" class="form-label">Select Genres</label>
                    <div class="row">
                        @foreach ($genres as $genre)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $genre->id }}" id="{{ $genre->name }}" name="genres[]">
                                <label class="form-check-label" for="{{ $genre->name }}">
                                    {{ $genre->name }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="author" class="form-label">Select Author</label>
                    <select class="form-select @error('author_id') is-invalid @enderror" name="author_id">
                        <option selected disabled>Choose author</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <small><span class="text-danger">* {{ $message }}</span></small>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="published_at" class="form-label">Published Date</label>
                    <input type="date" name="published_at" id="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at') }}" autofocus>
                    @error('published_at')
                        <small><span class="text-danger">* {{ $message }}</span></small>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="cover" class="form-label">Book Cover</label>
                    <input type="file" name="cover" id="" class="form-control @error('cover') is-invalid @enderror">
                    @error('cover')
                        <small><span class="text-danger">* {{ $message }}</span></small>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="pdf_file" class="form-label">Import PDF File</label>
                    <input type="file" name="pdf_file" id="" class="form-control @error('pdf_file') is-invalid @enderror">
                    @error('pdf_file')
                        <small><span class="text-danger">* {{ $message }}</span></small>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <button class="btn btn-primary" type="submit">Add book <i class="fa fa-plus"></i></button>
                    <a href="{{ route('books.list') }}" class="btn btn-danger">Cancle</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('custom_script')
<script>

    $('#name').change(function (e) {
        e.preventDefault();

        $.get("{{ route('books.checkSlug') }}", { 'name': $(this).val() },
            function (data) {
                $("#slug").val(data.slug);
            },
        );
    });

</script>
@endsection
