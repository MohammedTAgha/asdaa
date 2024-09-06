<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\CitizenCheckService;

use Tests\TestCase;
use App\Models\Citizen;
class ServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    protected $citizenCheckService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->citizenCheckService = new CitizenCheckService();
    }

    /** @test */
    public function it_checks_citizens_correctly()
    {
        // Create test citizens
        $region1 = \App\Models\Region::create(['name' => 'Region 1']);
        $region2 = \App\Models\Region::create(['name' => 'Region 2']);

        $existingCitizen1 = Citizen::create(['id' => 1, 'name' => 'John Doe', 'region_id' => $region1->id]);
        $existingCitizen2 = Citizen::create(['id' => 2, 'name' => 'Jane Doe', 'region_id' => $region1->id]);
        $existingCitizen3 = Citizen::create(['id' => 3, 'name' => 'Jim Beam', 'region_id' => $region2->id]);

        // Define the citizen IDs to check and the region ID
        $citizenIds = [1, 2, 4]; // 1 and 2 exist, 4 does not
        $regionId = $region1->id;

        // Call the service
        $result = $this->citizenCheckService->checkCitizens($citizenIds, $regionId);

        // Assert the results
        $this->assertEquals([1, 2], $result['exist']);
        $this->assertEquals([4], $result['not_exist']);
        $this->assertEquals([1, 2], $result['in_region']);
        $this->assertEquals([], $result['in_other_regions']);
    }
}
