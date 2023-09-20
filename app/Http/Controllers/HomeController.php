<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $id = Auth::id();
        $data = User::find($id);
        return view('home', compact('data'));
    }
    public function dashboard()
    {
        $id = Auth::id();
        $data = User::find($id);
        $tasks = $data->tasks;
        return view('index', compact('data','tasks'));
    }
}
