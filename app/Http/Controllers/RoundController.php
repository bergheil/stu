<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoundController extends Controller
{
    public $cardIdListNames;
    public $cardIdListIds;

    /**
     * Constructor
     * Create a list of cards and the list of the id
     */
    public function __construct() {
        $this->cardIdListIds = [];
        $this->cardIdListNames = [];
        $cardIdList = \DB::table('cards')->select('id','name')->get();
        foreach($cardIdList as $card) {
            $this->cardIdListIds[] = $card->id;
            $this->cardIdListNames[$card->id] = $card->name;
        }        
    }

    /**
     * Create a new game for N player
     * @param int $playersNumber Number of players 
     */
    public function createGame($playersNumber) {
        $resultGame = [];
        $totalCards = \App\Card::count();

        // Check if the player number is in the range
        $this->checkPlayerNumber($playersNumber, $totalCards);
        
        // calculate the number of card for each players
        $numberForEach = intdiv($totalCards,$playersNumber);

        // For each player I extract the cards
        $setBase = $this->cardIdListIds;
        for ($i=1; $i<=$playersNumber; $i++) {            
            $resultGame["Player " . $i] = implode(",",$this->extractRandomSetFromArray($numberForEach, $setBase));
        }
      
        return $resultGame;
    }

    /**
     * Random extract a $number elements from array $set.
     * The element extracted are removed from the set.
     * @param int $number Number of element to extract
     * @param array $set Set of elements where to extract
     * @return array Return a set of elements extracted
     */
    public function extractRandomSetFromArray($number, &$set) {
        $result = [];
        for($i=0; $i<$number; $i++) {
            $randIndex = array_rand($set);
            
            // Add the element to the result
            $idCard = $set[$randIndex];
            $result[] = $this->cardIdListNames[$idCard];

            // Remove the element extracted
            unset($set[$randIndex]);
        }        

        return $result;
    }

    /**
     * Check if the number of player is in the accetable range.
     * Between 2 and numberOfCard/2.
     * @param int $number Number of player  
     * @param int $totalCards Total number of cards   
     */
    private function checkPlayerNumber($playersNumber, $totalCards) {
        // Each player should have at least two card 
        // so I throw an exception if the are more than MAX/2 number of player
        // where MAX is the maximum number of card        
        if ($playersNumber > (intdiv($totalCards, 2))) {
            throw new \Exception("Sorry! The maximum number of player are " . (int)($totalCards/2));
        } 
        // At least 2 players
        if ($playersNumber < 2) {
            throw new \Exception("Sorry! The minimum number of player are 2");
        }
    }

    /**
     * Given a set of cards and a presented card calculate
     * the total points.
     * @param string $cardName Name of the card presented
     * @param string $cardList List of cards
     */
    public function getRoundPoint($cardName, $cardList) {           
        $cardObject = \App\Card::where('name', "=", $cardName)->first();                
        $cardListArray = explode(",", $cardList);        
        $cardListCollection = \App\Card::whereIn('name', $cardListArray)->get();                  
        try {
            if (!$cardObject) {
                throw new \Exception("Sorry, there was an error: cannot find {$cardName}");
            }
            $result = \App\Card::getCountResult($cardObject, $cardListCollection);
        } catch (\Exception $e) {            
            $result = "Sorry, there was an error: " . $e->getMessage();
        }
        return  $result;
    }
}
