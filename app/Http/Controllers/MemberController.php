<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return view('admin.member');
       
        // if ($request->gender) {
        //     $datas = Member::where('gender', $request->gender)->get();
        // } else {
        //     $datas = Member::all();
        // }

        // $datatables = datatables()->of($datas)->addIndexColumn();
        // return $datatables->make(true);


        if ($request->ajax()) {
            $gender = $request->gender;
            $datas = Member::when($gender, function ($query) use ($gender) {
                return $query->where('gender', $gender);
            })->get();
    
            $datatables = datatables()->of($datas)->addIndexColumn();
            return $datatables->make(true);
        }
    
        return view('admin.member');
       
    }

    public function api ()
    {
        $members = Member::all();
        $datatables = datatables()->of($members)
                            ->addColumn('date', function($member){
                                return convert_date($member->created_at);
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
            'gender' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'email' => ['required'],
            ]);
    
            Member::create($request->all());

            return redirect('members');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $this->validate($request,[
            'name' => ['required'],
            'gender' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'email' => ['required'],
            ]);
    
            $member->update($request->all());
                
            return redirect('members');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
    }
}
