<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Staff;
use Illuminate\Support\Facades\Log;

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
        Log::info('xxxxxxxxxxxxxxxxxx');
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->all();
        // dd(['data'=>$data]);
        // Handle the image upload
        if ($request->hasFile('image')) {
            Log::info('has image ');
            $imagePath = $request->file('image')->store('staff_images', 'public');
            Log::info('has image ');
            Log::info($imagePath);
            $data['image'] = $imagePath;
        }else {
            Log::info('No image uploaded.');
        }
    
        Staff::create($data);
    
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
        Log::info( '-----');
        $staff = Staff::findOrFail($id);
        Log::info( '-----');

        Log::info( $staff);
        $staff->fill($request->all());
        Log::info( 'staff updated');
        
        if ($request->hasFile('image')) {
            Log::info(' image uploaded.');
            // Delete the old image if exists
            if ($staff->image) {
                Storage::disk('public')->delete($staff->image);
            }
            
            $imagePath = $request->file('image')->store('staff_images', 'public');
            $staff->image = $imagePath;
            Log::info(' image pa.');
            Log::info($imagePath);
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