<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\RoundController;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Facades\Mail;

class RoundControllerTest extends TestCase
{
    // Using this trait the database test is refreshed before tests
    use RefreshDatabase;

    public $controller;

    public function setUp() :void {
        parent::setUp();
        Artisan::call('migrate', ['--seed' => true]);
        $this->controller = new RoundController();
    }

    
    /**
     * Try to play with more than the max number of player.
     * @expectedException Exception
     */
    public function testCreateGameMaxException() {
        $numberCards = \App\Card::count();
        $maxPlayer = ((int)($numberCards/2));
        $this->controller->createGame($maxPlayer+1);
    }

     /**
     * Try to play with more than the max number of player.
     * @expectedException Exception
     */
    public function testCreateGameMinException() {        
        $maxPlayer = 1;
        $this->controller->createGame($maxPlayer);
    }

    /**
     * Test the method extractRandomSetFromArray
     */
    public function testExtractRandomSetFromArray() {
        $set = ['1', '2', '3', '4', '5'];
        $number = 3;
        $expectedCount = 3;
        $result = $this->controller->extractRandomSetFromArray($number, $set);                
        $this->assertEquals($expectedCount, count($result), "Error! I expected ad array of {$expectedCount} elements");
    }

    /**
     * Test the method createGame of the controller
     */    
    public function testCreateGame() {
        $expected = 3;

        $result = $this->controller->createGame(3);
        // Check if I got an array for each player
        $this->assertEquals($expected, count($result), "I expected 3 array of cards");        
        
        // assert that the result is an array
        $this->assertTrue(is_array($result));        
    }

    /**
     * Test method getRoundPoint
     */
    public function testGetRoundPoint() {
        $card = "II red";
        $cardList = "III green,CUCCO green,SALTA red,I green";
        $expected = -2;
        $result = $this->controller->getRoundPoint($card, $cardList);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test method getRoundPoint with exception     
     */
    public function testGetRoundPointException() {
        $card = "II blue";
        $cardList = "III green,CUCCO green,SALTA red,I green";
        $expected = "Sorry, there was an error";
        $result = $this->controller->getRoundPoint($card, $cardList);
        $this->assertStringStartsWith($expected, $result);
    }
    
}
