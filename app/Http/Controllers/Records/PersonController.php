<?php

namespace App\Http\Controllers\Records;
use App\Http\Controllers\Controller;
use App\Models\Records\Person;
use App\Models\Records\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class PersonController extends Controller
{
    public function index()
    {
        return view('records.home');
    }
    
    public function search(Request $request)
    {
        $query = Person::query();
        
        // Handle both GET and POST methods
        $data = $request->isMethod('post') ? $request->all() : $request->query();
        
        if (!empty($data['id_number'])) {
            $query->where('CI_ID_NUM', 'like', '%' . $data['id_number'] . '%');
        }
        if (!empty($data['first_name'])) {
            $query->where('CI_FIRST_ARB', 'like', '%' . $data['first_name'] . '%');
        }
        if (!empty($data['father_name'])) {
            $query->where('CI_FATHER_ARB', 'like', '%' . $data['father_name'] . '%');
        }
        if (!empty($data['grandfather_name'])) {
            $query->where('CI_GRAND_FATHER_ARB', 'like', '%' . $data['grandfather_name'] . '%');
        }
        if (!empty($data['family_name'])) {
            $query->where('CI_FAMILY_ARB', 'like', '%' . $data['family_name'] . '%');
        }

        $startTime = microtime(true);
        $cacheKey = 'search_results:' . md5(serialize($data));
        
        if (Cache::has($cacheKey)) {
            $results = Cache::get($cacheKey);
            $executionTime = 0;
        } else {
            $results = Cache::remember($cacheKey, 60, function () use ($query) {
                return $query->get();
            });
            $endTime = microtime(true);
            $executionTime = round(($endTime - $startTime) * 1000, 2);
        }

        return view('records.home', compact('results', 'executionTime'));
    }

    public function show($id)
    {
        $citizen = Person::findOrFail($id);
       
        // Eager load first-level relatives with their basic information
        $relatives = Relation::with(['relative' => function($query) {
            $query->select('CI_ID_NUM', 'CI_FIRST_ARB', 'CI_FATHER_ARB', 'CI_FAMILY_ARB');
        }])->where('CF_ID_NUM', $id)->get();
    
        $secondLevelRelatives = collect();
    
        foreach ($relatives as $relation) {
            $relativeId = $relation->CF_ID_RELATIVE;
    
            // Eager load second-level relatives with their basic information
            $secondRelatives = Relation::with(['relative' => function($query) {
                $query->select('CI_ID_NUM', 'CI_FIRST_ARB', 'CI_FATHER_ARB', 'CI_GRAND_FATHER_ARB', 'CI_FAMILY_ARB');
            }])
            ->where('CF_ID_NUM', $relativeId)
            ->where('CF_ID_RELATIVE', '!=', $id)
            ->get();
    
            foreach ($secondRelatives as $secondRelation) {
                $relationName = $relation->relation_name;
    
                $secondLevelRelatives->push([
                    'relation_type' => $relationName,
                    'relative' => $secondRelation->relative,
                    'relation_code' => $secondRelation->CF_RELATIVE_CD,
                    'relation_name' => $secondRelation->relation_name,
                ]);
            }
        }
    
        return view('records.citizen-details', [
            'citizen' => $citizen,
            'relatives' => $relatives,
            'secondLevelRelatives' => $secondLevelRelatives->unique('relative.CI_ID_NUM'),
        ]);
    }

    public function showSearchByIdsForm()
    {
        return view('records.search-by-ids');
    }

    public function searchByIds(Request $request)
    {
        // Clean and prepare the input IDs
        $ids = explode(PHP_EOL, $request->input('ids'));
        $ids = array_map('trim', $ids);
        $ids = array_filter($ids);
        
        // Get existing records
        $existingResults = Person::whereIn('CI_ID_NUM', $ids)
            ->select('CI_ID_NUM', 'CI_FIRST_ARB', 'CI_FATHER_ARB', 'CI_GRAND_FATHER_ARB', 'CI_FAMILY_ARB', 
                'CI_PERSONAL_CD', 'CITTTTY', 'CITY', 'CI_BIRTH_DT', 'CI_SEX_CD', 'CI_DEAD_DT')
            ->get()
            ->keyBy('CI_ID_NUM');

        // Create a collection with all IDs, including non-existent ones
        $results = collect($ids)->map(function($id) use ($existingResults) {
            if ($existingResults->has($id)) {
                return $existingResults->get($id);
            }
            
            // Create a dummy record for non-existent ID
            $emptyPerson = new Person([
                'CI_ID_NUM' => $id,
                'CI_FIRST_ARB' => 'غير موجود',
                'CI_FATHER_ARB' => '',
                'CI_GRAND_FATHER_ARB' => '',
                'CI_FAMILY_ARB' => '',
                'CI_PERSONAL_CD' => '',
                'CITTTTY' => '',
                'CITY' => '',
                'CI_BIRTH_DT' => '',
                'CI_SEX_CD' => '',
                'CI_DEAD_DT' => ''
            ]);
            
            return $emptyPerson;
        });

        $request->session()->put('search_ids', $request->input('ids'));

        return view('records.search-by-ids', compact('results'));
    }

    public function showChildForm()
    {
        return view('records.search-childs');
    }

    public function searchChilds(Request $request)
    {
        // Clean and prepare the input IDs
        $ids = explode(PHP_EOL, $request->input('ids'));
        $ids = array_map('trim', $ids);
        $ids = array_filter($ids);
        
        // Get existing records
        $existingResults = Person::whereIn('CI_ID_NUM', $ids)
            ->select('CI_ID_NUM', 'CI_FIRST_ARB', 'CI_FATHER_ARB', 'CI_GRAND_FATHER_ARB', 'CI_FAMILY_ARB', 
                'CI_PERSONAL_CD', 'CITTTTY', 'CITY', 'CI_BIRTH_DT', 'CI_SEX_CD', 'CI_DEAD_DT')
            ->get()
            ->keyBy('CI_ID_NUM');

        // Create a collection with all IDs, including non-existent ones
        $results = collect($ids)->map(function($id) use ($existingResults) {
            if ($existingResults->has($id)) {
                return $existingResults->get($id);
            }
            
            // Create a dummy record for non-existent ID
            $emptyPerson = new Person([
                'CI_ID_NUM' => $id,
                'CI_FIRST_ARB' => 'غير موجود',
                'CI_FATHER_ARB' => '',
                'CI_GRAND_FATHER_ARB' => '',
                'CI_FAMILY_ARB' => '',
                'CI_PERSONAL_CD' => '',
                'CITTTTY' => '',
                'CITY' => '',
                'CI_BIRTH_DT' => '',
                'CI_SEX_CD' => '',
                'CI_DEAD_DT' => ''
            ]);
            
            return $emptyPerson;
        });

        $request->session()->put('search_ids', $request->input('ids'));

        return view('records.search-childs', compact('results'));
    }    public function searchById(Request $request)
    {
        $id = $request->input('id');
        
        Log::info('Searching for ID: ' . $id); // Add logging
        
        $person = Person::where('CI_ID_NUM', $id)->first();
        
        if (!$person) {
            Log::info('Person not found for ID: ' . $id); // Add logging
            return response()->json(['error' => 'Person not found'], 404);
        }
        
        Log::info('Found person: ' . json_encode($person)); // Add logging
        
        $data = [
            'person' => [
                'firstname' => $person->CI_FIRST_ARB,
                'secondname' => $person->CI_FATHER_ARB,
                'thirdname' => $person->CI_GRAND_FATHER_ARB,
                'lastname' => $person->CI_FAMILY_ARB,
                'gender' => $person->CI_SEX_CD == 1 ? 'ذكر' : 'انثى',
                'date_of_birth' => $person->CI_BIRTH_DT,
                'social_status' => $person->CI_PERSONAL_CD,
                'wife_id' => $person->spouse_id,
                'wife_name' => $person->spouse_name,
            ]
        ];
        
        Log::info('Returning data: ' . json_encode($data)); // Add logging
        return response()->json($data);
    }
}
