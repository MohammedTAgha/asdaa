<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Source;
class SourceController extends Controller
{
    public function index()
    {
        $sources = Source::all();
        return view('sources.index', compact('sources'));
    }

    public function create()
    {
        return view('sources.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:sources,email',
        ]);

        Source::create($request->all());

        return redirect()->route('sources.index')->with('success', 'Source created successfully.');
    }

    public function show(Source $source)
    {
        return view('sources.show', compact('source'));
    }

    public function edit(Source $source)
    {
        return view('sources.edit', compact('source'));
    }

    public function update(Request $request, Source $source)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:sources,email,' . $source->id,
        ]);

        $source->update($request->all());

        return redirect()->route('sources.index')->with('success', 'Source updated successfully.');
    }

    public function destroy(Source $source)
    {
        $source->delete();

        return redirect()->route('sources.index')->with('success', 'Source deleted successfully.');
    }
}
