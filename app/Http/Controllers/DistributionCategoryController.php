<?php

namespace App\Http\Controllers;

use App\Models\DistributionCategory;
use Illuminate\Http\Request;

class DistributionCategoryController extends Controller
{
    public function index()
    {
        $categories = DistributionCategory::all();
        return view('distribution_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('distribution_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
        ]);

        DistributionCategory::create($request->all());

        return redirect()->route('distribution_categories.index')->with('success', 'Category created successfully.');
    }

    public function show(DistributionCategory $category)
    {
        return view('distribution_categories.show', compact('category'));
    }

    public function edit(DistributionCategory $category)
    {
        return view('distribution_categories.edit', compact('category'));
    }

    public function update(Request $request, DistributionCategory $category)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('distribution_categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(DistributionCategory $category)
    {
        $category->delete();

        return redirect()->route('distribution_categories.index')->with('success', 'Category deleted successfully.');
    }
}