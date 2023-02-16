<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /* DB::listen(function ($query) {
            logger($query->sql, $query->bindings);
        }); */

        $latestBooks = Book::with('author')->latest()->get();
        return view('frontend.pages.home', compact('latestBooks'));
    }
}
