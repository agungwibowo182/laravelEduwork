<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
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
        return view('admin.publisher');
    }

    public function api ()
    {
        $publishers = Publisher::all();

        $datatables = datatables()->of($publishers)
                        ->addColumn('date', function($publisher){
                            return convert_date($publisher->created_at);
                        })->addIndexColumn();

        return $datatables->make(true); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('admin.publisher.create');
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
    
            Publisher::create($request->all());

            return redirect('publishers');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        // return view('admin.publisher.edit', compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $this->validate($request,[
            'name' => ['required'],
            'email' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
            ]);
    
            $publisher->update($request->all());
                
            return redirect('publishers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
    }
}
