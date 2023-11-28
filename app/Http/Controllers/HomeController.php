<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Publisher;
use App\Models\Catalog;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

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
        // $members = Member::all();
        // return $members;

        $publishers = Publisher::with('books')->get();
        return $publishers;
        return view('home');
    }
}
