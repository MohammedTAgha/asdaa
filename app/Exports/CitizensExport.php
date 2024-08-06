<?php

namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class CitizensExport implements FromQuery, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Citizen::query();

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
                    ->orWhere('secondname', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('thirdname', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('lastname', 'like', '%' . $request->input('search') . '%')
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
        return $query;
    }

    public function headings(): array
    {
        return [
            'id',
            'firstname',
            'secondname',
            'thirdname',
            'lastname',
            'phone',
            'family_members',
            'wife_id',
            'wife_name',
            'date_of_birth',
            'gender',
            'elderly_count',
            'obstruction',
            'obstruction_description',
            'disease',
            'disease_description',   
            'job', 
            'living_status',
            'social_status',
            'original_address',
            'region_id',
            'note',      
        ];
    }
}