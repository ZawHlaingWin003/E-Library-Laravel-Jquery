<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray()
            ]);
        } else {
            $review = new Review();
            $review->content = $request->content;
            $review->book_id = $request->book_id;
            $review->user_id = auth()->user()->id;
            $review->save();

            return response()->json([
                'status' => 200,
                'message' => 'Review Noted Successfully!'
            ]);
        }

    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return response()->json($review);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string'
        ]);


        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray()
            ]);
        } else {
            $review = Review::findOrFail($id);
            $review->content = $request->content;
            $review->update();

            return response()->json([
                'status' => 200,
                'message' => 'Review Updated Successfully!'
            ]);
        }
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Review Deleted Successfully!'
        ]);
    }
}
