<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;
use App\Plant;
/**
 * This is a controller, the "C" in MVC. It's used by our main routes file to
 * write in functions for the routes that are specifically utilized by the
 *  PlantController model. 
 * 
 */
class PlantController extends Controller
{   
    /** route for main view showing all plants (plants/index.php)
    *   @return view with plant data from the database
    *
    */
    public function index() {
        $plants = Plant::paginate(30);
        return view('plants.index', compact('plants'));

    }


    /** individual plant view route
    *   @return view showing data for plant of $id
    *
    */
    public function show($id) {

        // find a plant with that id. if not 404
        $plant = Plant::findOrFail($id);
        return view('plants.show', compact('plant'));
    }
    /** route for creating a new plant
    *   @return view of page with form for creating plant
    *
    */
    public function create() {
        return view('plants.create');
    }

    /** Route for storing a plant in the database (responds to post request)
    *   @return redirect to the create view with success/failure message
    *   TODO: figure out how to deal with failure/show different message when $plant->save fails
    */
    public function store(Request $request) {
        // make a new Plant object and set all of its attributes using data from the post request we received 
        $plant = new Plant();
        $plant->commonName = $request->commonName;
        $plant->division = $request->division;
        $plant->class = $request->class;
        $plant->order = $request->order;
        $plant->family = $request->family;
        $plant->genus = $request->genus;
        $plant->species = $request->species;
        $plant->variety = $request->variety;
        $saved = $plant->save();
        if (!$saved) {
            App::abort(500, 'Error');
        }

        // redirect to the creation page and show a msg about the creation succeeding
        return redirect('/plants');
    }

     /** route for deleting a plant
    *   @return redirect to /plants
    * TODO: find out about soft delete and what happens when $plant->delete() fails
    */
    public function destroy(Request $request) {
        if (Auth::user()->isAdmin()) {
            $id = $request->id;
            $plant = Plant::findOrFail($id);
            $plant->delete();
            return redirect('/plants');
        }
        else {
            App::abort(403, 'Permission denied');
        }
        
    }

}
