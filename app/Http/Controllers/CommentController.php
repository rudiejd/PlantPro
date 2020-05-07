<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    /** Main search route
    *   @return redirect to the submission the user was viewing
    * 
    */
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

    /**
     * Route for deleting a comment
     * @return redirect back to the submission the user was viewing
     * 
     */
    public function destroy($id) {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back();
    }




}
