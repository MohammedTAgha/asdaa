<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CitizenService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $citizenService;

    public function __construct(CitizenService $citizenService)
    {
        $this->citizenService = $citizenService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(Category::rules());
        
        Category::create($validated);
        
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate(Category::rules());
        
        $category->update($validated);
        
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Show the form for adding citizens to the category.
     */
    public function showAddCitizens(Category $category)
    {
        return view('categories.add-citizens', compact('category'));
    }

    /**
     * Add citizens to the category.
     */
    public function addCitizens(Request $request, Category $category)
    {
        $request->validate([
            'citizen_ids' => 'required|string'
        ]);

        // Convert the textarea input into an array of IDs
        $citizenIds = array_filter(
            array_map('trim', explode("\n", $request->citizen_ids)),
            'strlen'
        );

        if ($this->citizenService->addCitizensToCategory($citizenIds, $category->id)) {
            return redirect()
                ->route('categories.show', $category)
                ->with('success', 'Citizens successfully added to category.');
        }

        return back()
            ->with('error', 'Failed to add citizens to category.')
            ->withInput();
    }
}
