<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlantSubmission;


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
        $submissions = PlantSubmission::all();
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
        $submissions = $submissions;

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

    /** Route for storing a submission in the database (responds to post request)
    *   @return redirect to the create view with success/failure message
    *   TODO: figure out how to deal with failure/show different message
    */
    public function store() {
        $submission = new PlantSubmission();
        $submission->userId = request('userId');
        $submission->plantId = request('plantId');
        $submission->latitude = request('latitude');
        $submission->longitude = request('longitude');
        $submission->title = request('title');
        $submission->description = request('description');
        $submission->save();
        return redirect('/submissions/create')->with('msg', 'Successfully posted your plant sighting.');
    }

     /** route for deleting a submission
    *   @return redirect to /submissions
    * TODO: find out about soft delete and what happens when $plant->delete() fails
    */
    public function destroy($id) {
        $submission = PlantSubmission::findOrFail($id);
        $submission->delete();
        return redirect('/submission');

    }

}
