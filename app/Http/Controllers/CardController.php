<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Return the list of all cards
     */
    public function index() {
        return \App\Card::select('id', 'name')->orderBy('name')->get();
    }

    /**
     * Return all cards and for each one return the cards that can beat.
     */
    public function canbeat() {        
        $result = [];        
        $cardList = \App\Card::select('id', 'name')->orderBy('id')->get();        
        foreach ($cardList as $card) {            
            $result[$card->name] = $this->getCardCanBeatWeak($card->id);
        }        
        return $result;
    }

     /**
     * Return all cards that can beat a given card
     */
    public function canbeatcard($card) {        
        $result = [];        
        $cardList = \App\Card::select('id', 'name')->where('name', '=', trim($card))->orderBy('id')->get();        
        foreach ($cardList as $card) {            
            $result[$card->name] = $this->getCardCanBeatWeak($card->id);
        }        
        return $result;
    }

    /**
     * Return all cards and for each one return the cards that can beat.
     */
    public function stronger() {        
        $result = [];        
        $cardList = \App\Card::select('id', 'name')->orderBy('id')->get();        
        foreach ($cardList as $card) {            
            $result[$card->name] = $this->getCardCanBeatWeak($card->id, false);
        }        
        return $result;
    }

    /**
     * Get the list of the card that a given card $cardId beat.
     * If the parameter $weak is true return the list of the card that can beat
     * else the list of the stronger cards.
     * @param int $cardId Id of the card
     * @param bool $weak True if you need the weaker card, false otherwise
     */
    private function getCardCanBeatWeak($cardId, $weak = true) {
        if ($weak) {
            $compareValue = 1;
        } else {
            $compareValue = -1;
        }

        $canBeatList = \DB::table('cards')
            ->select('cards.id', 'cards.name')
            ->join('card_compares', 'card_compares.card_2_id', '=', "cards.id")
            ->where('card_compares.point', "=", $compareValue)
            ->where('card_compares.card_1_id', '=', $cardId)
            ->orderBy('cards.name')
            ->get();
        $arrWeak = [];
        foreach ($canBeatList as $cardWeak) {
            $arrWeak[] = $cardWeak->name;
        }
        return implode(",", $arrWeak);
    }
}
