<?php

namespace Tests\Unit;
use App\Plant;
use App\PlantSubmission;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlantSubmissionTest extends TestCase
{


    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
      
    }

    private function makeTestPlantSubmission() {
        $user = factory(User::class)->make();
        $user->save();
        $plant = new Plant();
        $plant->commonName = 'test';
        $plant->division = 'test';
        $plant->class = 'test';
        $plant->order = 'test';
        $plant->family = 'test';
        $plant->genus = 'test';
        $plant->species = 'test';
        $plant->variety = 'test';
        $plant->save();
    
        $submission = new PlantSubmission();
        $submission->userId = 1;
        $submission->plantId = 1;
        $submission->latitude = 4.20;
        $submission->longitude = 4.20;
        $submission->title = 'Nice';
        $submission->description = 'great plant bro';
        return $submission;
    }


    public function testCreatePlantSubmission() {
   
        $plantSubmission = $this->makeTestPlantSubmission();
        $this->assertInstanceOf(PlantSubmission::class, $plantSubmission);
        $this->assertTrue($plantSubmission->save());
        $plantSubmission->delete();
    }

    public function testReadPlantSubmission() {

        $submission = $this->makeTestPlantSubmission();
        $submission->save();
        $this->assertNotNull(PlantSubmission::find(1));
        $submission->delete();
    }

    public function testUpdatePlantSubmission() {

        $submission = $this->makeTestPlantSubmission();
        $submission->save();
        $submission->title = 'shut up';
        $submission->save();
        $this->assertEquals(PlantSubmission::first()['title'], 'shut up');
        $submission->delete();

    }

    public function testDeletePlantSubmission() {

        $submission = $this->makeTestPlantSubmission();
        $submission->save();
        $this->assertTrue($submission->delete());

    }
}
