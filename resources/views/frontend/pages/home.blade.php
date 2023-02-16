@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Home -->
    <section class="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-12">
                    <p class="intro">Welcome to our</p>
                    <h1 class="title display-4 mb-2">public <span class="text-primary">E</span>-library</h1>
                    <p class="description mb-4">
                        You can learn anything in our library for free.<br />
                        Remember! For Free, For Everyone.
                    </p>
                    <button class="btn btn-primary primary-btn">
                        Go To Library
                    </button>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="swiper stand-books-slider">
                        <div class="swiper-wrapper">
                            <a href="" class="swiper-slide"><img
                                    src="{{ asset('frontend/assets/images/books/book-1.png') }}" alt=""></a>
                            <a href="" class="swiper-slide"><img
                                    src="{{ asset('frontend/assets/images/books/book-2.png') }}" alt=""></a>
                            <a href="" class="swiper-slide"><img
                                    src="{{ asset('frontend/assets/images/books/book-3.png') }}" alt=""></a>
                            <a href="" class="swiper-slide"><img
                                    src="{{ asset('frontend/assets/images/books/book-4.png') }}" alt=""></a>
                            <a href="" class="swiper-slide"><img
                                    src="{{ asset('frontend/assets/images/books/book-5.png') }}" alt=""></a>
                            <a href="" class="swiper-slide"><img
                                    src="{{ asset('frontend/assets/images/books/book-6.png') }}" alt=""></a>

                        </div>
                        <img src="{{ asset('frontend/assets/images/stand.png') }}" class="stand" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About -->
    <section class="section container-fluid p-0">
        <div class="cover">
            <div class="overlay"></div>
            <div class="content text-center">
                <h1>Some Features That Made Us Unique</h1>
                <p>Lately it seems like we're all spending more time doing chores. Read on for 14 ideas to help you make
                    tedious tasks easier, less stressful.</p>
            </div>
        </div>
        <div class="container-fluid text-center">
            <div class="numbers d-flex flex-md-row flex-wrap justify-content-center">
                <div class="rect">
                    <h1 class="display-3">145</h1>
                    <p>Good Books</p>
                </div>
                <div class="rect">
                    <h1 class="display-3">84</h1>
                    <p>Smart Authors</p>
                </div>
                <div class="rect">
                    <h1 class="display-3">1056</h1>
                    <p>Happy Readers</p>
                </div>
                <div class="rect">
                    <h1 class="display-3">43</h1>
                    <p>Rare Books</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Books -->
    <section class="books">
        <div class="container">
            <h1 class="heading my-5"> <span>let's read books</span> </h1>

            <div class="recent-book-list">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="title">Recent Book List</h3>
                    <a href="#" class="btn btn-primary primary-btn">View All</a>
                </div>
                <hr>
                <div class="container swiper books-slider">
                    <div class="book-list swiper-wrapper">
                        @foreach ($latestBooks as $book)
                            <div class="book-card swiper-slide">
                                <div class="card p-3 border-0">
                                    <img src="{{ asset('covers/' . $book->cover) }}" alt="" class="book-cover">
                                    <hr>
                                    <h3 class="book-title text-center"><a
                                            href="{{ route('books.show', $book) }}">{{ $book->name }}</a></h3>
                                    <p class="book-author text-center mt-3">By : <a
                                            href="{{ route('authors.show', $book->author->id) }}">{{ $book->author->name }}</a>
                                    </p>
                                    <a href="{{ route('books.show', $book) }}" class="btn btn-primary primary-btn">Read
                                        More</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">

        <div class="container">
            <form action="{{ route('newsletter.subscribe') }}" method="POST" id="subscribe-form">
                @csrf
                <h2 class="title">subscribe for latest updates</h2>
                <div id="response" class="d-none"></div>
                <input type="email" name="email" class="form-control mt-3 @error('email') is-invalid @enderror"
                    placeholder="Enter Your Email" id="email" class="box" value="{{ old('email') }}">
                <small><span class="text-danger error email__err d-block mt-2 mb-3"></span></small>

                <button type="submit" class="btn btn-primary primary-btn subscribe-btn" id="btn">Subscribe</button>
            </form>
        </div>

    </section>
@endsection


@section('custom_script')
    <script>
        // Auto Count
        let nCount = selector => {
            $(selector).each(function() {
                $(this)
                    .animate({
                        Counter: $(this).text()
                    }, {
                        // A string or number determining how long the animation will run.
                        duration: 4000,
                        // A string indicating which easing function to use for the transition.
                        easing: "swing",
                        /**
                         * A function to be called for each animated property of each animated element.
                         * This function provides an opportunity to
                         *  modify the Tween object to change the value of the property before it is set.
                         */
                        step: function(value) {
                            $(this).text(Math.ceil(value));
                        }
                    });
            });
        };

        let a = 0;
        $(window).scroll(function() {
            // The .offset() method allows us to retrieve the current position of an element  relative to the document
            let oTop = $(".numbers").offset().top - window.innerHeight;
            if (a == 0 && $(window).scrollTop() >= oTop) {
                a++;
                nCount(".rect > h1");
            }
        });


        // Subscribed Form Submit
        $(document).ready(function() {
            $('#subscribe-form').submit(function(e) {
                e.preventDefault();
                let url = $(this).attr('action');
                $("#btn").attr('disabled', true).css('cursor', 'wait');

                var _token = $("input[name='_token']").val();
                var email = $("#email").val();

                console.log(email);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        _token: _token,
                        email: email
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('.error').text('');
                    },
                    success: function(data) {
                        if (data.code == 200) {
                            let success = '<p class="alert alert-success">' + data.response +
                                '</p>';

                            $("#response").addClass('d-block').removeClass('d-none').html(
                                success);
                            $("#subscribe-form")[0].reset();
                            $("#btn").attr('disabled', false).css('cursor', 'pointer');

                        } else if (data.code == 400) {
                            $.each(data.response, function(key, value) {
                                $("." + key + "__err").text(value);
                                $("#btn").attr('disabled', false).css('cursor',
                                    'pointer');
                            });
                        }
                    }
                });
            });
        })
    </script>
@endsection
