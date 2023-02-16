<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Book;
use App\Models\User;
use App\Models\Author;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user_count = count(User::all());
        $book_count = count(Book::all());
        $author_count = count(Author::all());

        $admin_users = AdminUser::orderBy('id', 'desc')->paginate(5);
        return view('dashboard.home', compact('admin_users', 'user_count', 'book_count', 'author_count'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
