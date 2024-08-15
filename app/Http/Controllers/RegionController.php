<?php

namespace App\Http\Controllers;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
   public function index(){
        // $regions=Region::all();
        // return response()->json($regions);
        $regions = Region::all();
        return view('regions.index', compact('regions'));
   }

   public function create()
   {
     
       return view("regions.create");
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        Region::create($request->all());
        return redirect()->route('regions.index')->with('success', 'Region created successfully.');
    }

    public function show($id)
    {
        $regions = Region::all();
        $region = Region::findOrFail($id);
        return view('regions.show', compact('region','regions'));
    }

    public function edit($id)
    {
        $region = Region::findOrFail($id);
        return view('regions.edit', compact('region'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        $region = Region::findOrFail($id);
        $region->update($request->all());

        return redirect()->route('regions.index')->with('success', 'Region updated successfully.');
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $region->delete();

        return redirect()->route('regions.index')->with('success', 'Region deleted successfully.');
    }
    
}
