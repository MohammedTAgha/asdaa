<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\Citizen;
class ChildController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $children = Child::with('citizen')->get();
        return view('children.index', compact('children'));
    }

    public function store(Request $request)
    {
        $validatedData= $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'citizen_id' => 'required|exists:citizens,id',
            'orphan' => 'sometimes|boolean',
            'infant' => 'sometimes|boolean',
            'bambers_size' => 'nullable|string|max:255',
            'disease' => 'sometimes|boolean',
            'disease_description' => 'nullable|string|max:255',
            'obstruction' => 'sometimes|boolean',
            'obstruction_description' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

       

        $child = Child::create($validatedData);
        
        return response()->json(['success' => true, 'child' => $child]);
    }

   public function create()
    {
        $citizens = Citizen::all();
        return view('children.create', compact('citizens'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $child = Child::with('citizen')->findOrFail($id);
        return view('children.show', compact('child'));
    }

    public function edit($id)
    {
        $child = Child::findOrFail($id);
        $citizens = Citizen::all();
        return view('children.edit', compact('child', 'citizens'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'citizen_id' => 'required|exists:citizens,id',
            'orphan' => 'sometimes|boolean',
            'infant' => 'sometimes|boolean',
            'bambers_size' => 'nullable|string|max:255',
            'disease' => 'sometimes|boolean',
            'disease_description' => 'nullable|string|max:255',
            'obstruction' => 'sometimes|boolean',
            'obstruction_description' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        $child = Child::findOrFail($id);
        $child->update($request->all());

        return redirect()->route('children.index')->with('success', 'Child updated successfully.');
    }

    public function destroy($id)
    {
        $child=Child::findOrFail($id);
        $child->delete();

        return response()->json(['success' => true]);
    }
}
