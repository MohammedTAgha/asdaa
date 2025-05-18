<?php

namespace App\Observers;

use App\Models\Citizen;
use App\Services\AutomaticFamilyAssignmentService;

class CitizenObserver
{
    protected $automaticFamilyAssignmentService;

    public function __construct(AutomaticFamilyAssignmentService $automaticFamilyAssignmentService)
    {
        $this->automaticFamilyAssignmentService = $automaticFamilyAssignmentService;
    }

    /**
     * Handle the Citizen "created" event.
     */
    public function created(Citizen $citizen): void
    {
        $this->automaticFamilyAssignmentService->assignFamilyMembers($citizen);
    }

    /**
     * Handle the Citizen "updated" event.
     */
    public function updated(Citizen $citizen): void
    {
        // Only trigger if id or wife_id changed
        if ($citizen->wasChanged(['id', 'wife_id'])) {
            $this->automaticFamilyAssignmentService->assignFamilyMembers($citizen);
        }
    }
}
