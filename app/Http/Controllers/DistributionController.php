<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\DistributionCategory;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        $distributions = Distribution::with('category')->get();
        return view('distributions.index', compact('distributions'));
    }

    public function create()
    {
        $categories = DistributionCategory::all();
        return view('distributions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'distribution_category_id' => 'required|exists:distribution_categories,id',
            'arrive_date' => 'required|date',
            'quantity' => 'required|integer',
            'target' => 'required',
            'source' => 'required',
            'done' => 'required|boolean',
            'target_count' => 'required|integer',
            'expectation' => 'required',
            'min_count' => 'required|integer',
            'max_count' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        Distribution::create($request->all());

        return redirect()->route('distributions.index')->with('success', 'Distribution created successfully.');
    }

    public function show(Distribution $distribution)
    {
        return view('distributions.show', compact('distribution'));
    }

    public function edit(Distribution $distribution)
    {
        $categories = DistributionCategory::all();
        return view('distributions.edit', compact('distribution', 'categories'));
    }

    public function update(Request $request, Distribution $distribution)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'distribution_category_id' => 'required|exists:distribution_categories,id',
            'arrive_date' => 'required|date',
            'quantity' => 'required|integer',
            'target' => 'required',
            'source' => 'required',
            'done' => 'required|boolean',
            'target_count' => 'required|integer',
            'expectation' => 'required',
            'min_count' => 'required|integer',
            'max_count' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $distribution->update($request->all());

        return redirect()->route('distributions.index')->with('success', 'Distribution updated successfully.');
    }

    public function destroy(Distribution $distribution)
    {
        $distribution->delete();

        return redirect()->route('distributions.index')->with('success', 'Distribution deleted successfully.');
    }
}