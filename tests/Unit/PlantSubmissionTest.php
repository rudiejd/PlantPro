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
        $plant = factory(Plant::class)->make();
        $plant->save();
        $submission = factory(PlantSubmission::class)->make(); 
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
