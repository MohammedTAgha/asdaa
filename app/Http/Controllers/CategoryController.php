<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\FamilyMemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    protected $familyMemberService;

    public function __construct(FamilyMemberService $familyMemberService)
    {
        $this->familyMemberService = $familyMemberService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::withCount('familyMembers')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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
            'description' => 'nullable|string',
            'size' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'date' => 'nullable|date',
            'property1' => 'nullable|string',
            'property2' => 'nullable|string',
            'property3' => 'nullable|string',
            'property4' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'تم إنشاء الفئة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category->load('familyMembers');
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
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
            'description' => 'nullable|string',
            'size' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'date' => 'nullable|date',
            'property1' => 'nullable|string',
            'property2' => 'nullable|string',
            'property3' => 'nullable|string',
            'property4' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'تم تحديث الفئة بنجاح');
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
        return redirect()->route('categories.index')
            ->with('success', 'تم حذف الفئة بنجاح');
    }

    public function addMembers(Request $request, Category $category)
    {
        Log::alert('test');
        Log::alert( $request);
        Log::alert( $category);

        $request->validate([
            'member_ids' => 'required|string',
            'size' => 'nullable|string',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'amount' => 'nullable|numeric',
            'property1' => 'nullable|string',
            'property2' => 'nullable|string',
            'property3' => 'nullable|string',
            'property4' => 'nullable|string',
        ]);

        try {
            $memberIds = array_filter(explode(',', $request->member_ids));
            $pivotData = [
                'size' => $request->size,
                'description' => $request->description,
                'date' => $request->date,
                'amount' => $request->amount,
                'property1' => $request->property1,
                'property2' => $request->property2,
                'property3' => $request->property3,
                'property4' => $request->property4,
            ];

            $this->familyMemberService->addMembersToCategory($category, $memberIds, $pivotData);

            return redirect()->route('categories.show', $category)
                ->with('success', 'تم إضافة الأعضاء إلى الفئة بنجاح');
        } catch (\Exception $e) {
            Log::error('Error adding members to category', [
                'category_id' => $category->id,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إضافة الأعضاء إلى الفئة');
        }
    }
}
