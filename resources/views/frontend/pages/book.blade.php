@extends('frontend.layouts.app')

@section('title', $book->name)

@section('custom_style')
<link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
<style>

.book-section{
    font-family: bodyRegularFont;
}
.book-cover img{
    width: 100%;
    height: 300px;
    object-fit: contain;
}

.pdf-wrapper{
    width: 100%;
    margin: 100px auto;
    text-align: center;
}
.pdf{
    width: 80%;
    height: 100vh;
    margin: 0 auto;
    border: 5px solid #000;
}


/* Heart Btn */
.heart-btn{
    display: inline-block;
}
.heart-btn .content{
    padding: 10px 15px;
    border: 2px solid #000;
    border-radius: 5px;
    cursor: pointer;
    position: relative;
}
.likeBtn.heart-active{
    border-color: #E2264D;
}
.heart-btn .heart{
    position: absolute;
    background: url('{{ asset('frontend/assets/images/heart-btn.png') }}') no-repeat;
    background-position: left;
    background-size: 2900%;
    height: 90px;
    width: 90px;
    top: 50%;
    left: 10%;
    transform: translate(-50%,-50%);
}
.heart-btn .text{
    color: #000;
    margin-left: 1.5rem;
}
.heart-btn .likeCount{
    margin-left: .2rem;
    color: #000;
}
.likeCount.heart-active, .text.heart-active{
    color: #E2264D;
}
.heart.heart-active{
    animation: animate .8s steps(28) 1;
    background-position: right;
}
@keyframes animate {
    0%{
        background-position: left;
    }
    100%{
        background-position: right;
    }
}

.username{
    font-family: titleRegularFont;
    font-size: 1.2rem;
    margin: 0;
}
.review-at{
    font-size: .8rem;
}

.actions{
    opacity: 0;
}
.review-card:hover .actions{
    opacity: 1;
    transition: all .2s;
}

.swal2-container{
    padding: 0;
}
body{
    padding: 0 !important;
}

</style>

@endsection

@section('content')

<section class='book-section container'>
    <a href="{{ route('books.index') }}" class="btn btn-primary primary-btn mb-5"><i class="fa fa-arrow-left"></i> To Library</a>
    <div class='book-detail'>
        <div class="row">
            <div class="col-md-5 border-top">
                <div class='image'>
                    <div class='content'>
                        <div class='book-cover p-3'>
                            <img alt='Card Image' src='{{ asset('covers/'.$book->cover) }}' class="img-fluid">
                        </div>
                    </div>
                    <div class="book-meta d-flex justify-content-center gap-5 mt-3 text-center">
                        <div class="reads meta-item">
                            <small>
                                <i class="fa fa-eye"></i>
                                <span class='text'>
                                    32 reads
                                </span>
                            </small>
                        </div>
                        <div class="likes meta-item">
                            <small>
                                <i class='fa fa-thumbs-up'></i>
                                <span class='text'>
                                    81 likes
                                </span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 p-5 pe-2 border-top border-start">
                <div class='text book-text'>
                    <span class='genre text-primary'>
                        @foreach ($book->genres as $genre)
                            <span class="pe-2 @if (!$loop->first) px-2 @endif">{{ $genre->name }}</span> @if (!$loop->last) | @endif
                        @endforeach
                    </span>
                    <h1 class='title my-3'>
                        {{ $book->name }}
                    </h1>
                    <div class='author'>
                        by {{ $book->author->name }}
                    </div>

                    <div class='published_at'>
                        <i class="fa fa-calender"></i>
                        {{ $book->published_at->format('d-m-Y') }}
                    </div>

                    <article class='description my-3'>
                        {{ $book->excerpt }}
                    </article>
                    <a href="#">Download</a>
                </div>
            </div>
        </div>


        <div class="pdf-wrapper">
            <iframe src="{{ asset('pdf_files/'.$book->pdf_file) }}#toolbar=0" id="pdf_file" class="pdf">
                This browser does not support PDFs. Please download the PDF to view it: Download PDF.
            </iframe>
        </div>

        <hr>
        <div class="blog-loveBtn">
            <h3>Do you recommend this book?</h3>
            <div class="heart-btn">
                <div class="likeBtn content">
                    <span class="heart"></span>
                    <span class="text">Love This Book</span>
                    <span class="likeCount">13</span>
                </div>
            </div>
        </div>
        <div class="card my-5">
            <div class="card-header">
                <strong>Total Reviews ({{ count($book->reviews) }})</strong>
            </div>
            <div class="card-body">

                @if (session('success'))
                    <p class="alert alert-success my-2">{{ session('success') }}</p>
                @endif
                @if (auth()->check())
                    <div class="form">
                        <input type="hidden" name="book_id" id="book_id" value="{{ $book->id }}">
                        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                        <div class="form-group mb-3">
                            <label for="review" class="mb-1">Book Review : </label>
                            <textarea name="content" id="add-content" class="form-control @error('content') is-invalid @enderror"></textarea>
                            <span class="text-danger error-text content_error"></span>
                        </div>
                        <button type="submit" class="btn btn-primary primary-btn" id="addReviewBtn">Add Review <i class="fa fa-plus"></i></button>
                    </div>
                @else
                    <h3 class="text-center">
                        You have to login to review books.
                        <a href="{{ route('login') }}" class="btn btn-primary primary-btn">Login</a>
                    </h3>
                @endif
            </div>
        </div>

        @foreach ($reviews as $review)
        <div class="card review-card p-3 mb-3">
            <div class="d-flex gap-3">
                <div class="user-img">
                    <img
                        src="https://ui-avatars.com/api/?name={{ $review->user->name }}"
                        alt="user-img"
                        width="38"
                        class="img-fluid rounded-circle"
                    />
                </div>
                <div style="width: 100%;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="info">
                            <p class="username">{{ $review->user->name }}</p>
                            <p class="review-at">{{ $review->updated_at->diffForHumans() }}</p>
                        </div>
                        @if (auth()->check() && auth()->user()->id == $review->user->id)
                            <div class="actions">
                                <button class="btn btn-sm btn-primary mx-3" id="editReviewBtn" data-id="{{ $review->id }}" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-id="{{ $review->id }}" id="deleteReviewBtn"><i class="fa fa-trash"></i></button>
                            </div>
                        @endif
                    </div>
                    <div class="review-content">
                        <p>{{ $review->content }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="review_id" id="review_id">
                        <div class="form-group my-3">
                            <label for="content">Book Review</label>
                            <textarea name="content" id="update-content" class="form-control"></textarea>
                            <span class="text-danger error-text content_error"></span>
                        </div>

                        <button type="submit" class="btn btn-primary primary-btn" id="updateReviewBtn">Save Changes</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>




@endsection


@section('custom_script')
<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<script>
    const likeBtn = document.querySelector(".likeBtn");
    const likeCount = document.querySelector(".likeCount");
    const text = document.querySelector(".text");
    const heart = document.querySelector(".heart");

    let clicked = false;

    likeBtn.addEventListener("click", function () {
        if (!clicked) {
            clicked = true;
            likeCount.textContent++;
            this.classList.add("heart-active");
            text.classList.add("heart-active");
            heart.classList.add("heart-active");
            likeCount.classList.add("heart-active");
        } else {
            clicked = false;
            this.classList.remove("heart-active");
            text.classList.remove("heart-active");
            heart.classList.remove("heart-active");
            likeCount.classList.remove("heart-active");
            likeCount.textContent--;
        }
    });

    toastr.options.preventDuplicates = true;

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '#addReviewBtn', function(){
        $(this).attr('disabled', 'true');

        var book_id = $('#book_id').val();
        var user_id = $('#user_id').val();
        var content = $('#add-content').val();
        var data = {
            'content' : content,
            'book_id' : book_id,
            'user_id' : user_id
        };

        $.ajax({
            type: "POST",
            url: "/review",
            data: data,
            success: function (response) {
                if(response.status == 200){
                    location.reload();
                    toastr.success(response.message);
                }else{
                    console.log(response.errors)
                    toastr.error(response.errors['content']);
                }
            }
        });
    })

    $(document).on('click', '#editReviewBtn', function(){
        console.log('Hello');
        var review_id = $(this).data('id');
        $.get('/review/'+review_id, function(data){
            $('#review_id').val(data.id);
            $('#update-content').val(data.content);
        });
    });

    $(document).on('click', '#updateReviewBtn', function(){
        var review_id = $('#review_id').val();
        var content = $('#update-content').val();
        var data = {
            'content': content
        };

        console.log(review_id, data)
        $.ajax({
            type: "PUT",
            url: "/review/update/"+review_id,
            data: data,
            success: function (response) {
                location.reload();

                if(response.status == 200){
                    toastr.success(response.message);
                }else{
                    toastr.error(response.message);
                }

                setTimeout(() => {

                }, );


            }
        });
    });


    $(document).on('click', '#deleteReviewBtn', function(){
        var review_id = $(this).data('id');

        swal.fire({
            title:'Are you sure?',
            showCancelButton:true,
            showCloseButton:true,
            cancelButtonText:'Cancel',
            confirmButtonText:'Yes',
            cancelButtonColor:'#d33',
            confirmButtonColor:'#556ee6',
            width:300,
            allowOutsideClick:false
        }).then(function(result){
            if(result.isConfirmed){
                $.ajax({
                    type: "DELETE",
                    url: '/review/destroy/'+review_id,
                    success: function (response) {
                        location.reload();

                        if(response.status == 200){
                            toastr.success(response.message);
                        }else{
                            toastr.error(response.message);
                        }
                    }
                });
            }
        });
    });




</script>
@endsection
