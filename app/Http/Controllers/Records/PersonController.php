<?php

namespace App\Http\Controllers\Records;
use App\Http\Controllers\Controller;

use App\Models\Person;
use App\Models\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\PersonsExport;

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
        // Filter by first name
        if ($request->filled('first_name')) {
            $query->where('CI_FIRST_ARB', 'like', '%' . $request->first_name . '%');
        }

        // Filter by father's name
        if ($request->filled('father_name')) {
            $query->where('CI_FATHER_ARB', 'like', '%' . $request->father_name . '%');
        }

        // Filter by grandfather's name
        if ($request->filled('grandfather_name')) {
            $query->where('CI_GRAND_FATHER_ARB', 'like', '%' . $request->grandfather_name . '%');
        }

        // Filter by family name
        if ($request->filled('family_name')) {
            $query->where('CI_FAMILY_ARB', 'like', '%' . $request->family_name . '%');
        }

        $startTime = microtime(true);
        $cacheKey = 'search_results:' . md5(serialize($request->all()));
        if (Cache::has($cacheKey)) {
            $results = Cache::get($cacheKey);
            $executionTime = 0; // Cache hit, set execution time to 0
        } else {
            $results = Cache::remember($cacheKey, 60, function () use ($request, $query) {
                $results = $query->with('relations')->get();
                return $results;
            });
            $endTime = microtime(true);
            $executionTime = round(($endTime - $startTime) * 1000, 2);
        }

        return view('records.home', compact('results', 'executionTime'));
    }
    public function show($id)
    {
        $citizen = Person::findOrFail($id);
        // dd($citizen->getWife());

        // Fetch first-level relatives
        $relatives = Relation::with('relative')
            ->where('CF_ID_NUM', $id)
            ->get();
    
        // Prepare a list to store categorized second-level relatives
        $secondLevelRelatives = collect();
    
        // Process each first-level relative
        foreach ($relatives as $relation) {
            $relativeId = $relation->CF_ID_RELATIVE;
    
            // Fetch relatives of the current relative (second-level relatives)
            $secondRelatives = Relation::with('relative')
                ->where('CF_ID_NUM', $relativeId)
                ->where('CF_ID_RELATIVE', '!=', $id) // Exclude the main citizen
                ->get();
    
            // Categorize these second-level relatives
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
            'secondLevelRelatives' => $secondLevelRelatives->unique('relative.CI_ID_NUM'), // Remove duplicates
        ]);
    }

    public function export(Request $request)
    {
        // $ids = explode(',', $request->query('ids'));
        // $ids = array_map('trim', $ids);
        // $results = Person::whereIn('CI_ID_NUM', $ids)->get();
        // // dd($results);
        // return Excel::download(new PersonsExport($results), 'citizens.xlsx');
    }


    public function showSearchByIdsForm()
    {
        return view('records.search-by-ids');
    }

    public function searchByIds(Request $request)
    {
        $ids = explode(PHP_EOL, $request->input('ids'));
        $results = Person::whereIn('CI_ID_NUM', $ids)->with('relations')->get();

        $request->session()->put('search_ids', $request->input('ids'));

        return view('records.search-by-ids', compact('results'));
    }
}
