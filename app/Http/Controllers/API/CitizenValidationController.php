<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use App\Services\CitizenValidationService;
use Illuminate\Http\JsonResponse;

class CitizenValidationController extends Controller
{
    protected $validationService;

    public function __construct(CitizenValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function validateCitizen(Citizen $citizen): JsonResponse
    {
        $results = $this->validationService->getDetailedValidationResults($citizen);
        
        return response()->json($results);
    }
} 