<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App;
use App\User;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    /**
     * Show the administration page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin()
    {
        if (Auth::user()->isAdmin()) {
            $users = User::all();
            return view('admin', compact('users'));
        }
        else {
            App::abort(403, 'Permission denied');
        }
        
    }

    
    /**
     * Make the given user an admin
     *
     * @return redirect back to admin page
     */
    public function makeAdmin(Request $request) {
        if (Auth::user()->isAdmin()) {
            if (User::find($request->userId)->isAdmin()) {
                return redirect()->back();
            }
            else {
                DB::table('Admin')->insert(['userId' => $request->userId]);
                return redirect()->back();
            }
        }
        else {
            App::abort(403, 'Permission denied.');
        }
    }

    /**
     * Make the given user a moderator
     *
     * @return redirect back to administration page
     */
    public function makeMod(Request $request) {
        if (Auth::user()->isAdmin()) {
            if (User::find($request->userId)->isMod()) {
                return redirect()->back();
            }
            else {
                DB::table('Moderator')->insert(['userId' => $request->userId]);
                return redirect()->back();
            }
        }
        else {
            App::abort(403, 'Permission denied.');
        }
    }

    /**
     * Remove a moderator
     *
     * @return redirect back to administration page
     */
    public function removeMod(Request $request) {
        if (Auth::user()->isAdmin()) {
            if (!User::find($request->userId)->isMod()) {
                return redirect()->back();
            }
            else {
                DB::table('Moderator')->where('userId', '=', $request->userId)->delete();
                return redirect()->back();
            }
        }
        else {
            App::abort(403, 'Permission denied.');
        }
    }
}
