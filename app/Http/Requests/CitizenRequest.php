<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CityEnum;

class CitizenRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust this based on your authorization logic
    }

    public function rules()
    {
        return [
            'firstname' => 'required|string|max:255',
            'secondname' => 'nullable|string|max:255',
            'thirdname' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'phone2' => 'nullable|string|max:15',
            'family_members' => 'required|integer|min:1',
            'wife_id' => 'nullable|integer',
            'wife_name' => 'nullable|string|max:255',
            'mails_count' => 'nullable|integer',
            'femails_count' => 'nullable|integer',
            'leesthan3' => 'nullable|integer',
            'obstruction' => 'nullable|integer',
            'obstruction_description' => 'nullable|string',
            'disease' => 'nullable|integer',
            'disease_description' => 'nullable|string',
            'job' => 'nullable|string|max:255',
            'living_status' => 'nullable|string|max:255',
            'original_address' => 'nullable|string',
            'note' => 'nullable|string',
            'region_id' => 'required|exists:regions,id',
            'city' => 'required|in:' . implode(',', array_column(CityEnum::cases(), 'value')),
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string',
            'widowed' => 'nullable|boolean',
            'social_status' => 'nullable|string',
            'elderly_count' => 'nullable|integer|min:0',
            'is_archived' => 'nullable|boolean',
        ];
    }
}