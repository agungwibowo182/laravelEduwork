<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Member;
use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.transaction.index');
    } 

    public function api(Request $request)
    {
        if($request->status){
            if($request->status == 'belum'){
                $transactions = Transaction::where('status', 0);
            } else {
                $transactions = Transaction::where('status', 1);
            }
        } elseif($request->date_start) {
            $date_start = date('Y-m-d', strtotime($request->date_start));
            $transactions = Transaction::where('date_start', $date_start);
        } else {
            $transactions = Transaction::all(); 
        }

        $datatables = datatables()->of($transactions)
                    ->editColumn('date_start', function($transaction){
                        return convert_date($transaction->date_start);
                    })
                    ->editColumn('date_end', function($transaction){
                        return convert_date($transaction->date_end);
                    })
                    ->editColumn('member_id', function($transaction){
                        return $transaction->member->name;
                    })
                    ->addColumn('lama_pinjam', function($transaction){
                        $date_start = Carbon::parse($transaction->date_start);
                        $date_end = Carbon::parse($transaction->date_end);
                        $days = $date_start->diffInDays($date_end);
                        return $days.' Hari';
                    })
                    ->addColumn('total_buku', function($transaction){
                        return $transaction->transaction_details->sum('qty');
                    })
                    ->addColumn('total_bayar', function($transaction){
                        $book_price = 0;
                        foreach($transaction->transaction_details as $transaction_detail){
                           $book_price += $transaction_detail->book->price;
                        };
                        return convert_rupiah($book_price);
                    })
                    ->editColumn('status', function($transaction){
                        return $transaction->status == 0 ? 'Belum Dikembalikan' : 'Sudah Dikembalikan';
                    })
                    ->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members = Member::all();
        $books = Book::where('qty', '!=', 0)->get();

        return view('admin.transaction.create', compact('members', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'member_id' => ['required', 'numeric'],
            'date_start' => ['required', 'date'],
            'date_end' => ['required', 'date'],
            'books_id.*' => ['required', 'numeric'],
        ]);
        
        $transaction = Transaction::create([
            'member_id' => $validated['member_id'],
            'date_start' => Carbon::parse($validated['date_start'])->format('Y-m-d'),
            'date_end' => Carbon::parse($validated['date_end'])->format('Y-m-d')
        ]);

        foreach($validated['books_id'] as $book_id){
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'book_id' => $book_id,
                'qty' => 1
            ]);
            $book = Book::find($book_id);
            $book->update(['qty' => $book->qty - 1]);
        }

        return redirect('transactions')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return view('admin.transaction.detail', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        if($transaction->status == 1) {
            return redirect('transactions')->with('warning', 'Status transaction yang sudah dikembalikan tidak bisa diedit kembali.');
        } else {
            return view('admin.transaction.edit', compact('transaction'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $this->validate($request, [
            'status' => ['required', 'accepted']
        ]);

        $transaction->update([ 'status' => $validated['status'] ]);

        foreach($transaction->transaction_details as $transaction_detail){
            $book = Book::find($transaction_detail->book_id);
            $book->update(['qty' => $book->qty + 1]);
        }
        return redirect('transactions')->with('success', 'Data berhasil diedit');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        if($transaction->status == 0){
            foreach($transaction->transaction_details as $transaction_detail){
                $book = Book::find($transaction_detail->book_id);
                $book->update(['qty' => $book->qty + 1]);
            }
        }
        TransactionDetail::where('transaction_id', $transaction->id)->delete();
        $transaction->delete();
        return redirect('transactions')->with('success', 'Data berhasil didelete');
    }
}
