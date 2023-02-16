<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Support\Facades\File;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::latest()->get();
        return view('frontend.pages.authors', compact('authors'));
    }

    public function search(Request $request)
    {
        $output = "";
        $authors = Author::where('name', 'LIKE', '%'.$request->search.'%')->latest()->get();
        if(count($authors)){
            foreach($authors as $key => $author){
                $output .=
                '
                <div class="col-md-3 my-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="profile">
                                <img src="'. asset('profiles/'.$author->profile) .'" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="card-footer">
                            <p><a href="'. route('authors.show', $author->id) .'">'. $author->name .'</a></p>
                        </div>
                    </div>
                </div>
                ';
            }
        }else{
            $output .= 
            '
            <div class="my-3">
                <h3>There is no author which named  >> <span class="text-danger">'.$request->search.'</span></h3>
            </div>
            ';
        }

        return response($output);
    }

    public function list()
    {
        $authors = Author::orderBy('id', 'desc')->paginate(5);
        return view('dashboard.authors.index', compact('authors'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('dashboard.authors.create');

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'biography' => 'required|string',
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $author = new Author();
        $author->name = $request->name;
        $author->biography = $request->biography;

        $profile = $request->file('profile');
        $file_path = date('YmdHis')."-".strtolower(str_replace(' ', '', $request->name)).'.'.$request->file('profile')->getClientOriginalExtension();
        $destinationPath = 'profiles/';
        $profile->move($destinationPath, $file_path);

        $author->profile = $file_path;

        $author->save();

        return back()->with('success', 'New author ('.$author->name.') added successfully!');
    }

    public function show(Author $author)
    {
        return view('frontend.pages.author', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('dashboard.authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string',
            'biography' => 'required|string',
            'profile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $author->name = $request->name;
        $author->biography = $request->biography;

        if($request->file('profile')) {

            $profile = $request->file('profile');
            $file_path = date('YmdHis')."-".strtolower(str_replace(' ', '', $request->name)).'.'.$request->file('profile')->getClientOriginalExtension();
            $destinationPath = 'profiles/';
            $profile->move($destinationPath, $file_path);

            $author->profile = $file_path;
        }else {
            unset($request->profile);
        }

        $author->update();

        return redirect()->route('authors.list')->with('success', 'Author updated successfully!');
    }

    public function destroy(Author $author)
    {
        $profile = "profiles/".$author->profile;
        if(File::exists($profile)){
            File::delete($profile);
        }
        $author->delete();
        return back()->with('success', 'Author deleted successfully!');
    }
}
