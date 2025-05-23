<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('attributes')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ]);

        $category = Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.form', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    // Category Attributes Methods
    public function attributesIndex(Category $category)
    {
        $attributes = $category->attributes()->orderBy('order')->get();
        return view('categories.attributes.index', compact('category', 'attributes'));
    }

    public function attributesCreate(Category $category)
    {
        return view('categories.attributes.form', compact('category'));
    }

    public function attributesStore(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:text,number,date,select,multiselect,textarea',
            'description' => 'nullable|string',
            'is_required' => 'boolean',
            'options' => 'nullable|string',
            'validation_rules' => 'nullable|string',
        ]);

        // Convert options from newline-separated string to array
        if (!empty($validated['options'])) {
            $validated['options'] = array_filter(explode("\n", $validated['options']));
        }

        // Convert validation rules from pipe-separated string to array
        if (!empty($validated['validation_rules'])) {
            $validated['validation_rules'] = explode('|', $validated['validation_rules']);
        }

        // Set the order to be the last one
        $validated['order'] = $category->attributes()->max('order') + 1;

        $category->attributes()->create($validated);

        return redirect()
            ->route('categories.attributes.index', $category)
            ->with('success', 'Attribute created successfully.');
    }

    public function attributesEdit(Category $category, CategoryAttribute $attribute)
    {
        return view('categories.attributes.form', compact('category', 'attribute'));
    }

    public function attributesUpdate(Request $request, Category $category, CategoryAttribute $attribute)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:text,number,date,select,multiselect,textarea',
            'description' => 'nullable|string',
            'is_required' => 'boolean',
            'options' => 'nullable|string',
            'validation_rules' => 'nullable|string',
        ]);

        // Convert options from newline-separated string to array
        if (!empty($validated['options'])) {
            $validated['options'] = array_filter(explode("\n", $validated['options']));
        }

        // Convert validation rules from pipe-separated string to array
        if (!empty($validated['validation_rules'])) {
            $validated['validation_rules'] = explode('|', $validated['validation_rules']);
        }

        $attribute->update($validated);

        return redirect()
            ->route('categories.attributes.index', $category)
            ->with('success', 'Attribute updated successfully.');
    }

    public function attributesDestroy(Category $category, CategoryAttribute $attribute)
    {
        $attribute->delete();

        return redirect()
            ->route('categories.attributes.index', $category)
            ->with('success', 'Attribute deleted successfully.');
    }

    public function attributesReorder(Request $request, Category $category)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:category_attributes,id',
            'order.*.order' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->order as $item) {
                CategoryAttribute::where('id', $item['id'])
                    ->update(['order' => $item['order']]);
            }
        });

        return response()->json(['success' => true]);
    }
}
