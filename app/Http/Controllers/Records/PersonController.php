<?php

namespace App\Http\Controllers\Records;
use App\Http\Controllers\Controller;
use App\Models\Records\Person;
use App\Models\Records\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        if ($request->filled('id_number')) {
            $query->where('CI_ID_NUM', 'like', '%' . $request->id_number . '%');
        }
        if ($request->filled('first_name')) {
            $query->where('CI_FIRST_ARB', 'like', '%' . $request->first_name . '%');
        }
        if ($request->filled('father_name')) {
            $query->where('CI_FATHER_ARB', 'like', '%' . $request->father_name . '%');
        }
        if ($request->filled('grandfather_name')) {
            $query->where('CI_GRAND_FATHER_ARB', 'like', '%' . $request->grandfather_name . '%');
        }
        if ($request->filled('family_name')) {
            $query->where('CI_FAMILY_ARB', 'like', '%' . $request->family_name . '%');
        }

        $startTime = microtime(true);
        $cacheKey = 'search_results:' . md5(serialize($request->all()));
        
        if (Cache::has($cacheKey)) {
            $results = Cache::get($cacheKey);
            $executionTime = 0;
        } else {
            $results = Cache::remember($cacheKey, 60, function () use ($request, $query) {
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
        $ids = explode(PHP_EOL, $request->input('ids'));
        $results = Person::whereIn('CI_ID_NUM', $ids)
            ->select('CI_ID_NUM', 'CI_FIRST_ARB', 'CI_FATHER_ARB', 'CI_GRAND_FATHER_ARB', 'CI_FAMILY_ARB', 
                'CI_PERSONAL_CD', 'CITTTTY', 'CITY', 'CI_BIRTH_DT', 'CI_SEX_CD', 'CI_DEAD_DT')
            ->get();

        $request->session()->put('search_ids', $request->input('ids'));

        return view('records.search-by-ids', compact('results'));
    }
}
