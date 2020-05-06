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
    function search(Request $request) {
        $query = $request->get('query');
        if (!isset($query) && empty($query)) {
            $submissions = PlantSubmission::all();
        }
        else {
            $submissions = PlantSubmission::where('title', 'like', '%'.$query.'%')->paginate(30);

        }
        return view('search', compact('submissions'));

    }
}
