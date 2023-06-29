<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;



class PublisherController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        return view ('admin.publisher');
    }

    public function api() 
    {
        $publishers = Publisher::all();
        $datatables = datatables()->of($publishers)->addIndexColumn();

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
        $this->validate($request,[
            'name' => ['required', 'string'],
            'gender' => ['required', 'in:L,P'],
            'phone_number' => ['required', 'digits_between: 11,13'],
            'address' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
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
        
        return view('admin.publisher.edit', compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
       $this->validate($request, [
        'name' => ['required', 'string', 'max:100'],
        'gender' => ['required', 'in:L,P'],
        'phone_number' => ['required', 'numeric', 'digits_between:11,13'],
        'address' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email'],
        ]);

        $publisher->update($request->all());

        //return $request;
        return redirect('publishers');
    }

    public function delete($id)
    {
        $publisher=Publisher::find($id);
        $publisher->delete();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
       
        $publisher->delete();
 
    }


}
