<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.warga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'email'=> 'required|unique:users',
        'rw' => 'required|string',
        'telpon'=>'required|string|max:15',
        'password' => 'required|min:3',


        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'rw_name' => $request->rw,
            'phone'=>$request->telpon,
            'password' => bcrypt($request->password),

        ]);
        return redirect()->route('admin.datawarga');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editdatauser= User::find($id);
        return view('admin.warga.edit', compact('editdatauser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'email'=> 'required',
        'rw' => 'required|string',
        'telpon'=>'required|string|max:15',
        'password' => 'required|min:3',
        ]);

        $editdatauser = User::findOrFail($id);

        $editdatauser->update([
            'name' => $request->name,
            'email' => $request->email,
            'rw_name' => $request->rw,
            'phone'=>$request->telpon,
            'password' => bcrypt($request->password),

        ]);
        return redirect()->route('admin.datawarga');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('admin.datawarga');
    }
}
