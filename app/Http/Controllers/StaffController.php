<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Staff;


class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('committee')->get();
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        $committees = Committee::all();
        return view('staff.create', compact('committees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            // 'image' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'committee_id' => 'nullable|exists:committees,id',
        ]);
        $staff = new Staff($request->all());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('staff_images', 'public');
            $staff->image = $imagePath;
        }
    
        $staff->save();
    
        return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
    
        // Staff::create($data);
        // return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
    }

    public function show(Staff $staff)
    {
        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $committees = Committee::all();
        return view('staff.edit', compact('staff', 'committees'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'committee_id' => 'nullable|exists:committees,id',
        ]);

        $staff = Staff::findOrFail($id);
        $staff->fill($request->all());
    
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($staff->image) {
                Storage::disk('public')->delete($staff->image);
            }
    
            $imagePath = $request->file('image')->store('staff_images', 'public');
            $staff->image = $imagePath;
        }
    
        $staff->save();
    
        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
        }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }
}