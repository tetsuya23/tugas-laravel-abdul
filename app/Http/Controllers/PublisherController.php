<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publishers = Publisher::with('books')->get();

        //return $request;
        return view ('admin.publisher.index', compact('publishers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.publisher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required'],
            'gender' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'email' => ['required'],

        ]);
        

        $publisher = new Publisher;
        $publisher->name = $request->name;
        $publisher->gender = $request->gender;
        $publisher->phone_number = $request->phone_number;
        $publisher->address = $request->address;
        $publisher->email = $request->email;
        $publisher->save();

        //return $request;
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
        $this->validate($request,[
            'name' => ['required'],
            'gender' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'email' => ['required'],

        ]);
        $publisher->update($request->all());

        //return $request;
        return redirect('publishers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher): RedirectResponse
    {
        //
    }


    public function __construct()
    {
    $this->middleware('web');
    }


    public function myMethod(Request $request, Publisher $publisher)
    {
        $value = $request->session()->get('key');
        // ...
    }
}
