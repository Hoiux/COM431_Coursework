<?php

namespace App\Http\Controllers;

use App\Models\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AjaxCOMMENTCRUDController extends Controller
{
    public function index()
    {
        return view('ajax-comment-crud');
    }

    public function fetchComments()
    {
        $comments = Comment::all();

        $comments_for_display = collect();

        foreach ($comments as &$comment) {
            if (!$comment->pending_approval) { // filter unapproved commments
                $comments_for_display->add($comment);
            }
        }

        unset($comment); // break the reference with the last element

        return response()->json([
            'comments' => $comments_for_display,
        ]);
    }

    // show the form for editing the specified comment
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required',
            'code' => 'required',
            'feedback' => 'required',
            'type' => 'required',
            'author_name' => 'required',
            'author_email' => 'required',
            'pending_approval' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        } else {
            $comment = new Comment;
            $comment->text = $request->input('text');
            $comment->code = $request->input('code');
            $comment->feedback = $request->input('feedback');
            $comment->type = $request->input('type');
            $comment->author_name = $request->input('author_name');
            $comment->author_email = $request->input('author_email');
            $comment->pending_approval = $request->input('pending_approval');

            $comment->save();
            return response()->json([
                'status' => 200,
                'message' => 'Comment Successfully Added.'
            ]);
        }
    }

    // edit an existing comment
    public function edit($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            return response()->json([
                'status' => 200,
                'comment' => $comment,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Comment Not Found.'
            ]);
        }
    }

    // update an existing comment
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required',
            'code' => 'required',
            'feedback' => 'required',
            'type' => 'required',
            'author_name' => 'required',
            'author_email' => 'required',
            'pending_approval' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        } else {
            $comment = Comment::find($id);
            if ($comment) {
                $comment->text = $request->input('text');
                $comment->code = $request->input('code');
                $comment->feedback = $request->input('feedback');
                $comment->type = $request->input('type');
                $comment->author_name = $request->input('author_name');
                $comment->author_email = $request->input('author_email');
                $comment->pending_approval = $request->input('pending_approval');

                $comment->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Comment with id:' . $id . ' Successfully Updated.'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Comment Not Found'
                ]);
            }
        }
    }

    // remove the specified comment
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Comment Successfully Deleted.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Comment Not Found.'
            ]);
        }
    }
}
