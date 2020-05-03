<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PlantSubmission;
use DB;

/**
 * This is a controller, the "C" in MVC. It's used by our main routes file to
 * write in functions for the routes that are specifically utilized by the
 *  PlantSubmission model. 
 * 
 */
class PlantSubmissionController extends Controller
{
    /** route for showing main submission page with all submissions
    *   @return view for showing main page with all submission data from the database
    *
    */
    public function index() {
        // get all submissions from database
        $submissions = PlantSubmission::all()->sortByDesc("upvotes");
        return view('submissions.index', compact('submissions'));

    }


    /** route for showing submissions for an individual plant
    *   @return view for plant submissions of id $id
    *
    */
    public function show($id) {
        // check if the plant has any submissions
        $first = PlantSubmission::where('plantId', $id)->first();
        if (!$first) {
            // if it doesn't have any submissions just send an empty array
            $submissions = [];
        }
        $submissions = PlantSubmission::where('plantId', $id)->get();

        // return the view with the data we got
        return view('submissions.show', compact('submissions', 'id'));
    }
    /** route for users to create plants
    *   @return view with form for creating a submission
    *
    */
    public function create() {
        // return the view for adding a new plant submission
        return view('submissions.create');
    }

    /** route for users to upvote an existing plant
     *  @return redirect back to the submission page
     *  
     */
    function upvote($id) {
        $hasUpvoted = DB::select('SELECT EXISTS ( SELECT NULL FROM UserUpvotes WHERE userId = :uid AND plantSubmissionId = :pid ) AS res', ['uid' => Auth::id(), 'pid' => $id])[0];
        // if the user has already upvoted the post, remove their upvote and redirect them
        if ($hasUpvoted->res == 1) {
            DB::delete('DELETE FROM UserUpvotes WHERE userId=:uid AND plantSubmissionId = :pid', ['uid' => Auth::id(), 'pid' => $id]);
            DB::update('UPDATE PlantSubmission SET upvotes = :newUpvotes WHERE plantSubmissionId = :pid', ['newUpvotes' => (PlantSubmission::find($id)->upvotes) + -1, 'pid' => $id ]);
            return redirect('/submissions/'.$id);
        }
        // otherwise insert the user Id and the plantsubmission id into the UserUpvotes table so we know the user has upvoted the plant
        else {
            DB::insert('INSERT INTO UserUpvotes (userId, plantSubmissionId) VALUES (:uid, :pid)', ['uid' => Auth::id(), 'pid' => $id]);
            DB::update('UPDATE PlantSubmission SET upvotes = :newUpvotes WHERE plantSubmissionId = :pid', ['newUpvotes' => (PlantSubmission::find($id)->upvotes) + 1, 'pid' => $id ]);
            return redirect('/submissions/'.$id);
        }
    }


    /** Route for storing a submission in the database (responds to post request)
    *   @return redirect to the create view with success/failure message
    */
    public function store(Request $request) {
        $submission = new PlantSubmission();
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $imageName = time().'.'.$request->image->extension();
        $lastId = DB::table('PlantSubmission')->orderByRaw('plantSubmissionId DESC')->first()->plantSubmissionId;
        $moved = $request->image->move(public_path('img').'/'.($lastId+1).'/', $imageName);
        if (!$moved) {
            App::abort(500, 'Error');
        }
        $submission->upvotes = 0;
        $submission->userId = $request->userId;
        $submission->plantId = $request->plantId;
        $submission->latitude = $request->latitude;
        $submission->longitude = $request->longitude;
        $submission->title = $request->title;
        $submission->description = $request->description;
        $saved = $submission->save();
        if (!$saved) {
            App::abort(500, 'Error');
        }
        return redirect('/submissions/create')->with('msg', 'Successfully posted your plant sighting.');
    }

     /** route for deleting a submission
    *   @return redirect to /submissions
    * TODO: find out about soft delete and what happens when $plant->delete() fails
    */  
    public function destroy(Request $request) {
        
        $id = $request->id;
        $submission = PlantSubmission::findOrFail($id);
        if (sizeof(DB::table('Admin')->where('userId', '=', $request->userId)->get()) === 0 && $submission->userId != $request->userId) {
            App::abort(403, 'Permission denied');
        }
        $submission->delete();
        return redirect('/submission');

    }

}
