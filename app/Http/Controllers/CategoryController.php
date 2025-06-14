<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\FamilyMemberService;
use App\Exports\CategoryMembersExport;
use App\Exports\CategoryMembersTemplateExport;
use App\Imports\CategoryMembersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\FamilyMember;

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
      

        // $request->validate([
        //     'member_ids' => 'required|string',
        //     'ids' => 'required|string',

        //     'size' => 'nullable|string',
        //     'description' => 'nullable|string',
        //     'date' => 'nullable|date',
        //     'amount' => 'nullable|numeric',
        //     'property1' => 'nullable|string',
        //     'property2' => 'nullable|string',
        //     'property3' => 'nullable|string',
        //     'property4' => 'nullable|string',
        // ]);
        // Log::alert('ids', $request->input('ids'));
        
        $ids = explode(PHP_EOL, $request->input('ids'));
        
        $ids = array_map('trim', $ids);
        $ids = array_filter($ids);

        // dd($ids);
        try {
            // $memberIds = array_filter(explode(',', $request->member_ids));
                    // Clean and prepare the input IDs
      
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

            $this->familyMemberService->addMembersToCategory($category, $ids, $pivotData);

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
    public function addMember(Request $request)
    {
        Log::alert($request);
        try {
            $request->validate([
                'member_id' => 'required|string',
                'category_id' => 'required|numeric',
                'description' => 'nullable|string',
                'date' => 'nullable|date',
                'size' => 'nullable|string',
                'amount' => 'nullable|numeric',
                'property1' => 'nullable|string',
                'property2' => 'nullable|string',
                'property3' => 'nullable|string',
                'property4' => 'nullable|string',
            ]);

            $category = Category::findOrFail($request->category_id);
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

            $this->familyMemberService->addMembersToCategory($category, [$request->member_id], $pivotData);

            return response()->json([
                'success' => true,
                'message' => 'تم إضافة العضو إلى الفئة بنجاح'
            ]);
        } catch (\Exception $e) {
            Log::error('Error adding member to category', [
                'category_id' => $request->category_id,
                'member_id' => $request->member_id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إضافة العضو إلى الفئة: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export category members to Excel
     *
     * @param  \App\Models\Category  $category
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Category $category)
    {
        return Excel::download(new CategoryMembersExport($category), "category-{$category->id}-members.xlsx");
    }

    /**
     * Show the import form for category members
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function importForm(Category $category)
    {
        return view('categories.import', compact('category'));
    }

    /**
     * Import members to the category from Excel file
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request, Category $category)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        try {
            $import = new CategoryMembersImport($category);
            Excel::import($import, $request->file('file'));

            $report = $import->getReport();
            
            return redirect()
                ->route('categories.show', $category)
                ->with('success', "تم استيراد {$report['successes']} عضو بنجاح")
                ->with('import_report', $report);
        } catch (\Exception $e) {
            Log::error('Error importing category members', [
                'category_id' => $category->id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء استيراد الملف: ' . $e->getMessage());
        }
    }

    /**
     * Download the template for importing category members
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadTemplate()
    {
        return Excel::download(new CategoryMembersTemplateExport, 'category-members-template.xlsx');
    }

    public function removeMember(Category $category, FamilyMember $member)
    {
        try {
            $category->familyMembers()->detach($member->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
