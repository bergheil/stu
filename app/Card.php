<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    /**
     * Compare the current Card with the card in the parameter $newCard
     * @param object $newCard The card to compare
     * @return int return 1 if the cart is greater, -1 if is weaker or 0 if equal
     */
    public function compareWith(Card $newCard) {
        $result = 0;

        $resultQuery = \DB::table('card_compares')
            ->select('point')
            ->where('card_1_id', '=', $this->id)
            ->where('card_2_id', '=', $newCard->id)
            ->first();

        if ($resultQuery) {
            $result = $resultQuery->point;
        }

        return $result;
    }


    /**
     * Return the count of the points for a round given the card $card.
     * For each card in $cardRound return the sum of the point of the card 
     * compared with the choosen $card
     * @param object $cardChoosen Card choosen
     * @param array  Cards array of the round
     * @return int Total points of the turn
     */
    public static function getCountResult($cardChoosen, $cardRound) {
        $result = 0;        
        foreach($cardRound as $card) {               
            $result += $cardChoosen->compareWith($card);
        }
        
        return $result;
    }
}
