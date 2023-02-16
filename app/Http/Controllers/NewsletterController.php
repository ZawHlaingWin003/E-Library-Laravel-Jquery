<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\UserSubscribed;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletters,email|max:255'
        ]);

        if($validation->fails()){
            return response()->json(['code' => 400, 'response' => $validation->errors()->toArray()]);
        }

        event(new UserSubscribed($request->email));


        return response()->json(['code' => 200, 'response' => "Successfully subscribed! Check your email"]);
    }

    public function list()
    {
        $emails = Newsletter::orderBy('id', 'desc')->paginate(5);
        return view('dashboard.subscribed_emails.index', compact('emails'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
