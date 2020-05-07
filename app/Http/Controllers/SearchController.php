<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use App\PlantSubmission;
use App\Plant;
use DB;

class SearchController extends Controller
{

    /** Main search route
    *   @return view with results
    * 
    */  
    function search(Request $request) {
        $query = $request->get('query');
        $userId = $request->get('userId');
        $plantId = $request->get('plantId');
        if (!isset($query) || empty($query)) {
            $submissions = PlantSubmission::paginate(15);
        }
        else {
            $submissions = PlantSubmission::where('title', 'like', '%'.$query.'%');
            if (isset($userId) && !empty($userId)) {
                $submissions = $submissions->where('userId', '=', $userId);
            }
            if (isset($plantId) && !empty($plantId)) {
                $submissions = $submissions->where('plantId', '=', $plantId);
            }
            $submissions = $submissions->paginate(15);
        }
        return view('search', compact('submissions'));

    }
}
