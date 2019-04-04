<?php

namespace Tests\Feature;

use Mockery;
use App\Card;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CardController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardControllerTest extends TestCase
{
    // Using this trait the database test is refreshed before tests
    use RefreshDatabase;

    public $controller;

    public function setUp() :void {
        parent::setUp();
        Artisan::call('migrate', ['--seed' => true]);
        $this->controller = new CardController();
    }

    
    /**     
     * Test the method canBeat
     * @return void
     */
    public function testCanBeat()
    {       
        $expected = \App\Card::count();
        $result = $this->controller->canbeat();
        $this->assertEquals($expected, count($result));
    }

    /**     
     * Test the method stronger
     * @return void
     */
    public function testStronger()
    {       
        $expected = \App\Card::count();
        $result = $this->controller->stronger();
        $this->assertEquals($expected, count($result));
    }

    /**     
     * Test the method canBeatCard
     * @return void
     */
    public function testCanBeatCard()
    {       
        $expected = ['LEONE red' => ''];
        $result = $this->controller->canbeatcard('LEONE red');
        $this->assertEquals($expected, $result);
    }

    /**     
     * Test the method index
     * @return void
     */
    public function testIndex()
    {       
        $expected = \App\Card::select('id', 'name')->orderBy('name')->get();
        $result = $this->controller->index();
        $this->assertEquals($expected, $result);
    }
}
