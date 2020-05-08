<?php

namespace Tests\Unit;
use App\Plant;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlantTest extends TestCase
{


    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
      
    }

    private function makeTestPlant() {
        $plant = factory(Plant::class)->make();
        return $plant;
    }


    public function testCreatePlant() {
   
        $plant = $this->makeTestPlant();
        $this->assertInstanceOf(Plant::class, $plant);
        $this->assertTrue($plant->save());
        $plant->delete();
    }

    public function testReadPlant() {

        $plant = $this->makeTestPlant();
        $plant->save();
        $this->assertNotNull(Plant::find(1));
        $plant->delete();
    }

    public function testUpdatePlant() {

        $plant = $this->makeTestPlant();
        $plant->save();
        $plant->commonName = 'jeremy';
        $plant->save();
        $this->assertEquals(Plant::find(1)['commonName'], 'jeremy');
        $plant->delete();

    }

    public function testDeletePlant() {

        $plant = $this->makeTestPlant();
        $plant->save();
        $this->assertTrue($plant->delete());

    }
}
