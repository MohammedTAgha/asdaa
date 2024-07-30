<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Region;
use App\Models\Distribution;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    public function index(Request $request)
    {

        $query = Citizen::query();
        $regions = Region::all();
        $distributions = Distribution::all();
        // Apply search filter
        if ($request->has('search') && !empty($request->input('search'))) {
            $query->where('firstname', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('secondname', 'like', '%' . $search . '%')
                    ->orWhere('thirdname', 'like', '%' . $search . '%')
                    ->orWhere('lastname', 'like', '%' . $search . '%')
                    ->orWhere('wife_name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('id', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('note', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->has('id') && !empty($request->input('id'))) {
            $query->where('id', $request->input('id'));
        }

        // Apply age filter
        if ($request->has('age') ) {
            $query->where('age', $request->input('age'));
        }

        if ($request->has('gender') && !empty($request->input('gender'))) {
            $query->where('gender', $request->input('gender'));
        }
        // Apply region filter (handle multiple regions)
        if ($request->has('regions')  && !empty($request->input('regions'))) {
            //dd($request->input('regions'));
            $query->whereIn('region_id', $request->regions);
        }

    
        $sortField = $request->get('sort', 'name'); // Default sort field
        $sortDirection = $request->get('direction', 'asc'); // Default sort direction
        
       
        $perPage = $request->input('per_page', 10);
       // $citizens = Citizen::all();
       
        $citizens = $query->get();
        //dd($citizens );

        // if ($request->isMethod('post')) {
        //     // Return a view
        //     
        // } 

        // if ($request->wantsJson()) {
            
        // }
        //dd($request->input('returnjson'));
        // $contentType = $request->header('Content-Type');
        // if ($contentType != 'application/json') {
        //     
        // }
        if($request->has('returnjson') && $request->input('returnjson')==1){

            return response()->json($citizens);
        }
    return view('citizens.index', compact('citizens', 'sortField', 'sortDirection', 'perPage','regions','distributions'));
    }

    public function query(Request $request)
    {
        $query = Citizen::query();

        // Apply filters based on query parameters
        if ($request->has('id')) {
            $query->where('id', $request->input('id'));
        }
        if ($request->has('first_name')) {
            $query->where('first_name', 'like', '%' . $request->input('first_name') . '%');
        }
        if ($request->has('second_name')) {
            $query->where('second_name', 'like', '%' . $request->input('second_name') . '%');
        }
        if ($request->has('third_name')) {
            $query->where('third_name', 'like', '%' . $request->input('third_name') . '%');
        }
        if ($request->has('last_name')) {
            $query->where('last_name', 'like', '%' . $request->input('last_name') . '%');
        }

        // Execute query and get results
        $citizens = $query->get();

        return response()->json($citizens);
    }
    
    
    public function show($id)
    {
        $citizens=Citizen::all();
        $citizen = Citizen::with('children')->findOrFail($id);
        return view('citizens.show', compact('citizen','citizens'));
    }

    public function create()
    {
        $regions = Region::all();
        return view('citizens.create',compact('regions'));
    }

    public function store(Request $request)
    {
   
       
        $data = [
            'id' => $request->input('id'),
            'name' => $request->input('name'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'region_id' => $request->input('region_id'),
            'wife_id' => $request->input('wife_id'),
            'wife_name' => $request->input('wife_name'),
            'widowed' => $request->input('widowed'),
            'social_status' => $request->input('social_status'),
            'living_status' => $request->input('living_status'),
            'job' => $request->input('job'),
            'original_address' => $request->input('original_address'),
            'elderly_count' => $request->input('elderly_count'),
            'note' => $request->input('note'),

        ];
        
        Citizen::create($data);

       
   
       return redirect()->route('citizens.index')->with('success', 'Citizen created successfully.');
    }

    public function edit($id)
    {
        $citizen = Citizen::findOrFail($id);
        return view('citizens.edit', compact('citizen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            // Add other validation rules as needed
        ]);

        $citizen = Citizen::findOrFail($id);
        $citizen->update($request->all());
        return redirect()->route('citizens.index')->with('success', 'Citizen updated successfully.');
    }

    public function destroy($id)
    {
        $citizen = Citizen::findOrFail($id);
        $citizen->delete();
        return redirect()->route('citizens.index')->with('success', 'Citizen deleted successfully.');
    }
}

