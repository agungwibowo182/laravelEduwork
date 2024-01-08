<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        // return $catalogs;
        return view('admin.author');
    }

    public function api ()
    {
        $authors = Author::all();

        // udah date
        // foreach ($authors as $key => $author) {
        //     $author->date = convert_date($author->created_at);
        // }


        $datatables = datatables()->of($authors)
                            ->addColumn('date', function($author){
                                return convert_date($author->created_at);
                            })->addIndexColumn();

        return $datatables->make(true); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  validasi data
         $this->validate($request,[
            'name' => ['required'],
            'email' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
            ]);
    
            Author::create($request->all());

            return redirect('authors');

        // return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $this->validate($request,[
            'name' => ['required'],
            'email' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
            ]);
    
            $author->update($request->all());
                
            return redirect('authors');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
    }
}
