<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        return view('admin.member');
    }
    
     public function api(Request $request)
    {
        if ($request->gender) {
            $datas = Member::where('gender', $request->gender)->get();
        } else {
            $datas = Member::all();
        }

        $datatables = datatables()->of($datas)->addIndexColumn();
      
        return $datatables->make(true);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'string'],
            'gender' => ['required', 'in:L,P'],
            'phone_number' => ['required', 'digits_between: 11,13'],
            'address' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
        ]);
        Member::create($request->all());

        return back();
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
        return view('admin.member.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'in:L,P'],
            'phone_number' => ['required', 'numeric', 'digits_between:11,13'],
            'address' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
            ]);
    
            $member->update($request->all());
    
            //return $request;
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
