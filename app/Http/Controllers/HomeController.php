<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

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


        // nomor 1
        $data1 = DB::table('members')
                    ->select('*')
                    ->join('users', 'users.member_id', '=', 'members.id')
                    ->get();

        // nomor 2
        $data2 = DB::table('members')
                    ->select('*')
                    ->leftJoin('users', 'users.member_id', '=', 'members.id')
                    ->where('users.id', NULL)
                    ->get();

        // nomor 3
        $data3 = DB::table('transactions')
                    ->select('members.id', 'members.name')
                    ->rightJoin('members', 'members.id', '=', 'transactions.member_id')
                    ->where('transactions.member_id', NULL)
                    ->get();

        // nomor 4
        $data4 = DB::table('members')
                    ->select('members.id', 'members.name', 'members.phone_number')
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->orderBy('members.id', 'asc')
                    ->get();
        
        // nomor 5
        $data5 = DB::table('members')
                    ->select('members.id', 'members.name', 'members.phone_number', DB::raw('count(members.id) as count'))
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->groupBy('members.id')
                    ->havingRaw('count(members.id) > 1')
                    ->get();
        
        // nomor 6
        $data6 = DB::table('members')
                    ->select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->get();

        // nomor 7
        $data7 = DB::table('members')
                    ->select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->whereMonth('date_end', '=', '06')
                    ->get();

        // nomor 8
        $data8 = DB::table('members')
                    ->select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->whereMonth('date_start', '=', '05')
                    ->get();

        // nomor 9
        $data9 = DB::table('members')
                    ->select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->whereMonth('date_start', '=', '06')
                    ->whereMonth('date_end', '=', '06')
                    ->get();

        // nomor 10
        $data10 = DB::table('members')
                    ->select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->where('address', 'LIKE', '%bandung%')
                    ->get();

        // nomor 11
        $data11 = DB::table('members')
                    ->select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->where('address', 'LIKE', '%bandung%')
                    ->where('gender', '=', 'P')
                    ->get();

        // nomor 12
        $data12 = DB::table('members')
                    ->select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end', 'books.isbn', 'transaction_details.qty')
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
                    ->join('books', 'books.id', '=', 'transaction_details.book_id')
                    ->where('transaction_details.qty', '>', 1)
                    ->get();

        // nomor 13
        $data13 = DB::table('members')
                    ->select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end', 'books.isbn', 'transaction_details.qty', 'books.title', 'books.price', DB::raw('SUM(transaction_details.qty * books.price) as total'))
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
                    ->join('books', 'books.id', '=', 'transaction_details.book_id')
                    ->groupBy('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end', 'books.isbn', 'transaction_details.qty', 'books.title', 'books.price')
                    ->get();

        // nomor 14
        $data14 = DB::table('members')
                    ->select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end', 'books.isbn', 'transaction_details.qty', 'books.title', 'publishers.name as publisher', 'authors.name as author', 'catalogs.name as catalog')
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
                    ->join('books', 'books.id', '=', 'transaction_details.book_id')
                    ->join('publishers', 'publishers.id', '=', 'books.publisher_id')
                    ->join('authors', 'authors.id', '=', 'books.author_id')
                    ->join('catalogs', 'catalogs.id', '=', 'books.catalog_id')
                    ->get();

        // nomor 15
        $data15 = DB::table('catalogs')
                    ->select('catalogs.id', 'catalogs.name as catalog', 'books.title as book_title')
                    ->join('books', 'books.catalog_id', '=', 'catalogs.id')
                    ->get();

        // nomor 16
        $data16 = DB::table('books')
                    ->select('books.*', 'publishers.name as publisher')
                    ->leftJoin('publishers', 'publishers.id', '=', 'books.publisher_id')
                    ->get();

        // nomor 17
        $data17 = DB::table('books')
                    ->select('books.author_id', DB::raw('count(books.id) as count'))
                    ->where('books.author_id', '=', 5)
                    ->groupBy('books.author_id')
                    ->get();

        // nomor 18
        $data18 = DB::table('books')
                    ->where('books.price', '>', 10000)
                    ->get();

        // nomor 19
        $data19 = DB::table('books')
                    ->select('books.*', 'publishers.name as publisher')
                    ->join('publishers', 'publishers.id', '=', 'books.publisher_id')
                    ->where('publishers.name', 'LIKE', '%Penerbit 01%')
                    ->where('books.qty', '>', 10)
                    ->get();

        // nomor 20
        $data20 = DB::table('members')
                    ->whereMonth('created_at', '=' , 06)
                    ->get();

        // return $data1;
        
        return view('home');
    }
}