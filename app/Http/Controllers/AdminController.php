<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function index()
    {
        $books = Book::count();
        $members = Member::count();
        $publishers = Publisher::count();
        $transactions = Transaction::count();

        // grafik peminjaman
        $label_bar = ['Peminjaman', 'Pengembalian'];
        $data_bar = [];

        foreach($label_bar as $key => $value){
            $data_bar[$key]['label'] = $label_bar[$key];
            $data_bar[$key]['backgroundColor'] = $key == 0 ? 'rgba(60, 141, 188, 0.9)' : 'rgba(210, 214, 222, 1)';
            $data_month = [];

            foreach(range(1,12) as $month){
                if($key == 0){
                    $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_start', $month)->first()->total;
                } else {
                    $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_end', $month)->where('status', 1)->first()->total;
                }
            }
            $data_bar[$key]['data'] = $data_month;
        }
        // grafik peminjaman

        // grafik katalog
        $data_pie = DB::table('books')
                    ->select('books.catalog_id', DB::raw('count(books.id) as count'))
                    ->groupBy('books.catalog_id')
                    ->pluck('count');

        $label_pie = DB::table('catalogs')
                    ->join('books', 'books.id', '=', 'catalogs.id')
                    ->pluck('name');
        // grafik katalog

        return view('home', compact('books', 'members', 'publishers', 'transactions', 'data_bar', 'data_pie', 'label_pie',));
    }

    public function test_spatie()
    {
        // $role = Role::create(['name' => 'petugas']);
        // $permission = Permission::create(['name' => 'index peminjaman']);

        // $role->givePermissionTo($permission);
        // $permission->assignRole($role);

        // $user = auth()->user();
        // $user->assignRole('petugas');
        // return $user;

        // $user = User::with('roles')->get();
        // return $user;

        // $user = User::where('id', 2)->first();
        // $user->removeRole('petugas');
    }
}
