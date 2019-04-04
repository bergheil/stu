<?php

namespace Tests\Feature;

use Mockery;
use App\Card;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardTest extends TestCase
{
    // Using this trait the database test is refreshed before tests
    use RefreshDatabase;

    public function setUp() :void {
        parent::setUp();
        Artisan::call('migrate', ['--seed' => true]);
    }

    /**
     * Test the method "compareWith"    
     * @return void
     */
    public function testCompareWith() {
        $card1 = new Card();
        $card1->id = 1;
        $card1->name = "I";
        $card2 = new Card();
        $card2->id = 2;
        $card2->name = "II";
                 
        $expected = -1;
        $result = $card1->compareWith($card2);
        $this->assertEquals($expected, $result, "Compare error with card1={$card1->name} and card2={$card2->name}");        
    }

    /**
     * Test the method countResult
     * @dataProvider getRoundData
     */
    public function testGetCountResult($choosen, $cardList, $expected) {            
        $cardsRound = \App\Card::whereIn("name", $cardList)
            ->get();
        $cardChoosen = \App\Card::where('name', $choosen)
            ->first();       
            
        $result = \App\Card::getCountResult($cardChoosen, $cardsRound);
        $this->assertEquals($expected, $result);
    }

    /**
     * Data provider for testing getCountResult
     */
    public function getRoundData() {  
        return [
            ['CUCCO red', ['II green', 'III red', 'IIII green'], 3],
            ['I red', ['II red', 'III red'], -2],
            ['II red', ['I red', 'III red'], 0],
            ['II red', ['II green', 'III red'], -1],
            ['V red', ['II green', 'III red', 'IIII green'], 3]            
        ];
    }
}
