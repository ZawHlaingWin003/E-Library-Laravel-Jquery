<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;
use App\Imports\BooksImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Cviebrock\EloquentSluggable\Services\SlugService;

class BookController extends Controller
{

    public function index()
    {

        $latestBook = Book::latest()->first();
        $books = Book::with('author')->latest()->get();
        return view('frontend.pages.books', compact('books', 'latestBook'));
    }

    public function list()
    {
        $books = Book::with('author')->latest()->paginate(6);
        return view('dashboard.books.index', compact('books'))->with('i', (request()->input('page', 1) - 1) * 6);
    }

    public function create()
    {
        $authors = Author::latest()->get();
        $genres = Genre::latest()->get();
        return view('dashboard.books.create', compact('authors', 'genres'));
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Book::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|alpha_dash|unique:books',
            'excerpt' => 'required|string',
            'author_id' => 'required',
            'published_at' => 'required',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pdf_file' => 'required|mimes:pdf'
        ]);

        $book = new Book();
        $book->name = $request->name;
        $book->excerpt = $request->excerpt;
        $book->author_id = $request->author_id;
        $book->published_at = $request->published_at;

        $cover = $request->file('cover');
        $cover_file_path = date('YmdHis')."-".strtolower(str_replace(' ', '', $request->slug)).'.'.$request->file('cover')->getClientOriginalExtension();
        $destinationPath = 'covers/';
        $cover->move($destinationPath, $cover_file_path);
        $book->cover = $cover_file_path;

        $pdf_file = $request->file('pdf_file');
        $pdf_file_path = date('YmdHis')."-".strtolower(str_replace(' ', '', $request->slug)).'.'.$request->file('pdf_file')->getClientOriginalExtension();
        $destinationPath = 'pdf_files/';
        $pdf_file->move($destinationPath, $pdf_file_path);
        $book->pdf_file = $pdf_file_path;

        $book->save();

        $genres = Genre::find($request->genres);
        $book->genres()->attach($genres);

        return back()->with('success', 'New book ('.$book->name.') added successfully!');
    }

    public function show(Book $book)
    {
        $reviews = Review::where('book_id', $book->id)->orderBy('updated_at', 'desc')->get();
        return view('frontend.pages.book', compact('book', 'reviews'));
    }

    public function edit(Book $book)
    {
        $authors = Author::latest()->get();
        $genres = Genre::latest()->get();
        return view('dashboard.books.edit', compact('book', 'authors', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|alpha_dash|unique:books,slug,'.$book->id,
            'excerpt' => 'required|string',
            'author_id' => 'required',
            'published_at' => 'required',
            'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pdf_file' => 'mimes:pdf'
        ]);

        $book->name = $request->name;
        $book->excerpt = $request->excerpt;
        $book->author_id = $request->author_id;
        $book->published_at = $request->published_at;

        if($request->file('cover')) {
            $old_cover = "covers/".$book->cover;
            if(File::exists($old_cover)) {
                File::delete($old_cover);
            }
            $cover = $request->file('cover');
            $cover_file_path = date('YmdHis')."-".strtolower(str_replace(' ', '', $request->slug)).'.'.$request->file('cover')->getClientOriginalExtension();
            $destinationPath = 'covers/';
            $cover->move($destinationPath, $cover_file_path);

            $book->cover = $cover_file_path;
        }else {
            unset($request->cover);
        }

        if($request->file('pdf_file')) {
            $old_pdf_file = "pdf_files/".$book->pdf_file;
            if(File::exists($old_pdf_file)) {
                File::delete($old_pdf_file);
            }

            $pdf_file = $request->file('pdf_file');
            $pdf_file_path = date('YmdHis')."-".strtolower(str_replace(' ', '', $request->slug)).'.'.$request->file('pdf_file')->getClientOriginalExtension();
            $destinationPath = 'pdf_files/';
            $pdf_file->move($destinationPath, $pdf_file_path);

            $book->pdf_file = $pdf_file_path;
        }else {
            unset($request->pdf_file);
        }

        $genres = Genre::find($request->genres);
        $book->genres()->sync($genres);

        $book->update();

        return back()->with('success', 'Book ('.$book->name.') updated successfully!');
    }

    public function destroy(Book $book)
    {
        $cover = "covers/".$book->cover;
        if(File::exists($cover)) {
            File::delete($cover);
        }

        $pdf_file = "pdf_files/".$book->pdf_file;
        if(File::exists($pdf_file)) {
            File::delete($pdf_file);
        }

        $genres = $book->genres;
        $book->genres()->detach($genres);

        $book->delete();

        return back()->with('success', 'Book "'.$book->name.'" deleted successfully!');
    }
}
