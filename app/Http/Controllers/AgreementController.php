<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Illuminate\Http\Request;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.agreement.index', ['agreement' => Agreement::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Agreement $agreement)
    {
        return view('admin.agreement.create', compact('agreement'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Agreement::create($this->validateRequest($request));
        return redirect(route('agreement.index'))->with('success', 'Agreement created Sucessful!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function show(Agreement $agreement)
    {
        return view('admin.agreement.show', compact('agreement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function edit(Agreement $agreement)
    {
        return view('admin.agreement.edit', compact('agreement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agreement $agreement)
    {
        $agreement->update($this->validateRequest($request));
        return redirect(route('agreement.index'))->with('success', 'Agreement update Sucessful!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agreement $agreement)
    {
        $agreement->delete();
        return redirect(route('agreement.index'))->with('success', 'Agreement deleted Sucessful!!');
    }

    public function validateRequest($request)
    {
        return $request->validate([
            'name' => 'required',
            'content' => 'required',
        ]);
    }
}
