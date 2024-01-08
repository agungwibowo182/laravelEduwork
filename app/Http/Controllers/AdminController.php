<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Book;
use App\Models\Catalog;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Transaction;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home()
    {
        $total_member = Member::count();
        $total_book = Book::count();
        $total_transaction = Transaction::whereMonth('date_start', date('m'))->count();
        $total_publisher = Publisher::count();

        // $data_donut = Book::select(DB::raw("COUNT(publisher_id) as total"))->groupBy('publisher_id')->orderBy('publisher_id', 'asc')->pluck('total');
        // $label_donut = Publisher::orderBy('publisher_id', 'asc')->join('books', 'books.publisher_id', '=', 'publishers.id')->pluck('name');

        // $label_bar = ['Transaction'];
        // $data_bar = [];

        // foreach ($label_bar as $key => $value) {
        //     $data_bar[$key]['label'] = $label_bar[$key];
        //     $data_month = [];

        //     foreach (range(1,12) as $month) {
        //         $data_month[] = Transaction::select(DB::raw("COUNT(*)as total"))->whereMonth('tgl_pinjam',$month)->first()->total;
        //     }
        //     $data_bar[$key]['data'] = $data_month;
        // }   
        return view('home', compact('total_member', 'total_book','total_transaction','total_publisher'));
    }
    public function catalog()
    {
        $data_katalog = Catalog::all();
        return view('admin.catalog.index',compact('data_katalog'));
    }

    public function publisher()
    {
        $data_publisher = Publisher::all();
        return view('admin.publisher',compact('data_publisher'));
    }

    public function author()
    {
        $data_author = Author::all();
        return view('admin.author',compact('data_author'));
    }

    public function member()
    {
        $data_member = Member::all();
        return view('admin.member',compact('data_member'));
    }

    public function book()
    {
        $data_buku= Book::all();
        return view('admin.book',compact('data_book'));
    }
}
