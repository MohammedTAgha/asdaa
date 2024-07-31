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
        $distribution=null;
        $distributionId=$request->input('distributionId');
        if($request->has('distributionId') && !empty($request->input('distributionId'))){
            $distribution=Distribution::find($request->input('distributionId'));
        }

         // Apply filters based on query parameters
         if ($request->has('id') && !empty($request->input('id'))) {
            $query->where('id', $request->input('id'));
        }
        if ($request->has('first_name') && !empty($request->input('first_name'))) {
            $query->where('firstname', 'like', '%' . $request->input('first_name') . '%');
        }
        if ($request->has('second_name') && !empty($request->input('second_name'))) {
            $query->where('secondname', 'like', '%' . $request->input('second_name') . '%');
        }
        if ($request->has('third_name') && !empty($request->input('third_name'))) {
            $query->where('thirdname', 'like', '%' . $request->input('third_name') . '%');
        }
        if ($request->has('last_name') && !empty($request->input('last_name'))) {
            $query->where('lastname', 'like', '%' . $request->input('last_name') . '%');
        }

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
        if($request->has('returnjson') && $request->input('returnjson')==1){

            return response()->json($citizens);
        }
    return view('citizens.index', compact('citizens', 'sortField', 'sortDirection', 'perPage','regions','distributions','distributionId'));
    }

    public function query(Request $request)
    {
        $query = Citizen::query();

       

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
            'firstname' => $request->input('firstname'),
            'secondname' => $request->input('secondname'),
            'thirdname' => $request->input('thirdname'),
            'lastname' => $request->input('lastname'),
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
        
            'id' => 'required|string|max:255',
            'firstname' => 'required|string',
            'secondname' => 'nullable|string',
            'thirdname' => 'nullable|string',
            'lastname' => 'required|string',
            // 'date_of_birth' => 'nullable|date',
            // 'gender' => 'nullable|string',
            // 'region_id' => 'nullable|string',
            // 'wife_id' => 'nullable|string',
            // 'wife_name' => 'nullable|string',
            // 'widowed' => 'nullable|string',
            // 'social_status' => 'nullable|string',
            // 'living_status' =>'nullable|string',
            // 'job' =>'nullable|string',
            // 'original_address' =>'nullable|string',
            // 'elderly_count' => 'nullable|string',
            'note' => 'nullable|string',
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

