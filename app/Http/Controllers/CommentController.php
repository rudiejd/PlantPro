<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    
    public function store() {
        $comment = new Comment();
        $comment->userId = request('userId');
        $comment->plantSubmissionId = request('plantSubmissionId');
        $comment->body = request('body');
        if (request('parentId') !== null) {
            $comment->parentId = request('parentId');
        }
        else {
            $comment->parentId = 0;
        }
        
        $comment->upvotes = 0;
        $saved = $comment->save();
        if (!$saved) {
            App::abort(500, 'Error');
        }
        return redirect()->back();
    }


    // imma implement this later
    public function upvote($id) {
        
    }

    public function destroy($id) {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back();
    }




}
