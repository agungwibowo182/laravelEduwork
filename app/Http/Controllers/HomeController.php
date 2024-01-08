<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Publisher;
use App\Models\Catalog;
use App\Models\Author;
use App\Models\Book;
use App\Models\Transaction;
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
        //testing relasi db
        // $members = Member::all();
        // return $members;

        // $publishers = Publisher::with('books')->get();
        // return $publishers;
        // end testing


        //No. 1
        // $data = Member::select('*')
        //         ->join('users', 'users.member_id', '=', 'member_id')
        //         ->get();

        // //No. 2
        // $data2 = Member::select('*')
        //         ->leftJoin('users', 'users.member_id', '=', 'members.id')
        //         ->where('users.id', NULL)
        //         ->get();
        
        // //No. 3
        // $data3 = Transaction::select('members.id', 'members.name')
        //         ->rightJoin('members', 'member_id', '=', 'transactions.member_id')
        //         ->where('transactions.member_id', NULL)
        //         ->get();

        // //No. 4
        // $data4 = Member::select('members.id', 'members.name', 'members.phone_number')
        //         ->join('transactions', 'transactions.member_id', '=', 'member_id')
        //         ->orderBy('member_id', 'asc')
        //         ->get();

        //No. 5
        // $data4 = Member::select('members.id', 'members.name', 'members.phone_number')
        //         ->join('transactions', 'transactions.member_id', '=', 'member_id')
        //         ->orderBy('member_id', 'asc')
        //         ->get();

        // return $data4;
        return view('home');
    }
}