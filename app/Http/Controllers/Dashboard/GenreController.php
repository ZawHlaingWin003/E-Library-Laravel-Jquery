<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{

    public function index()
    {
        $genres = Genre::orderBy('id', 'desc')->get();
        return view('frontend.pages.genres', compact('genres'));
    }

    public function list()
    {
        $genres = Genre::orderBy('id', 'desc')->paginate(12);
        return view('dashboard.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('dashboard.genres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:genres,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        /* $names = explode(",", $request->name);

        foreach ($names as $name) {
            $genre = new Genre();
            $genre->name = $name;
            $genre->save();
        } */

        $genre = new Genre();
        $genre->name = $request->name;

        $image = $request->file('image');
        $file_path = date('YmdHis')."-".strtolower(str_replace(' ', '', $request->name)).'.'.$request->file('image')->getClientOriginalExtension();
        $destinationPath = 'genre_images/';
        $image->move($destinationPath, $file_path);
        $genre->image = $file_path;


        $genre->save();

        return back()->with('success', 'Genre added successfully!');
    }

    public function show(Genre $genre)
    {
        return view('frontend.pages.genre', compact('genre'));
    }

    public function edit(Genre $genre)
    {
        return view('dashboard.genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|unique:genres,name,'.$genre->id,
        ]);

        $genre->name = $request->name;

        if($request->file('image')) {

            $image = $request->file('image');
            $file_path = date('YmdHis')."-".strtolower(str_replace(' ', '', $request->name)).'.'.$request->file('image')->getClientOriginalExtension();
            $destinationPath = 'genre_images/';
            $image->move($destinationPath, $file_path);

            $genre->image = $file_path;
        }else {
            unset($request->image);
        }

        $genre->update();

        return redirect()->route('genres.list')->with('success', 'Genres Updated successfully!');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return back()->with('success', 'Genre deleted successfully!');
    }
}
