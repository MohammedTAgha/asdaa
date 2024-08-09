<?php

namespace App\Http\Controllers;


use App\Models\Committee;
use App\Models\Staff;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function index()
    {
        $committees = Committee::with('manager')->get();
        return view('committees.index', compact('committees'));
    }

    public function create()
    {
        $managers = Staff::all();
        return view('committees.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'manager_id' => 'nullable|exists:staff,id',
            'description' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        Committee::create($data);
        return redirect()->route('committees.index')->with('success', 'Committee created successfully.');
    }

    public function show(Committee $committee)
    {
        return view('committees.show', compact('committee'));
    }

    public function edit(Committee $committee)
    {
        $managers = Staff::all();
        return view('committees.edit', compact('committee', 'managers'));
    }

    public function update(Request $request, Committee $committee)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'manager_id' => 'nullable|exists:staff,id',
            'description' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $committee->update($data);
        return redirect()->route('committees.index')->with('success', 'Committee updated successfully.');
    }

    public function destroy(Committee $committee)
    {
        $committee->delete();
        return redirect()->route('committees.index')->with('success', 'Committee deleted successfully.');
    }
}