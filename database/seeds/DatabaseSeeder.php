<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add cards
        $cardList = [
            'I' => 1,
            'II' => 2,
            'III' => 3,
            'IIII' => 4,
            'V' => 5,
            'VI' => 6,
            'VII' => 7,
            'VIII' => 8,
            'IX' => 9,
            'X' => 10,
            'CANTINA' => 11,
            'GNAO' => 12,
            'SALTA' => 13,
            'BRAGON' => 14,
            'CUCCO' => 15,
            'LEONE' => -1,
            'MATTO' => -1,
            'SECCHIO' => -1,
            'MASCHERONE' => -1,
            'NULLA' => -1
        ];

        
        $this->insertCardColor(array_keys($cardList), "red");        
        $this->insertCardColor(array_keys($cardList), "green");        
               
        // Insert card compare relationship
        foreach ($cardList as $cardName => $cardVal) {
            // Create record in compare table
            $this->insertCardCompare($cardName, "red", $cardList);
            $this->insertCardCompare($cardName, "green", $cardList);
        }
    }

    /**
     * Insert card with a color
     * @param array $cardList List of the card to insert
     * @param string $color Color of the card
     */
    public function insertCardColor($cardList, $color) {
        foreach($cardList as $card) {
            DB::table('cards')->insert(
                array('name' => $card . " " . $color)
            );
        }
    }

    /**
     * Insert record in compare table
     * @param string $cardName Name of the card     
     * @param string $color Color of the card
     * @param array $cardList list of all card
     */
    private function insertCardCompare($cardName, $color, $cardList) {
        // Get the value of the cardName and the id
        $val1 = $cardList[$cardName];
        $dbName = $cardName . " " . $color;                
        $cardResult = DB::table('cards')->select('id', 'name')->where('name', $dbName)->first();
        $idCard1 = $cardResult->id;
        
        // Select all the card different from $cardName . $color
        $cardResult = DB::table('cards')
            ->select('id', 'name')
            ->where('id', '!=', $idCard1)
            ->get();

        foreach ($cardResult as $card) {
            // Get the value of the card and the Id
            $name = $card->name;
            $idCard2 = $card->id;
            
            // read the value of the card
            $val2 = $cardList[str_replace([" red", " green"], "", $name)];            
            
            // Add a compare method
            $this->addCompare($idCard1, $idCard2, $val1, $val2);
        }   
    }
    
    /**
     * Add the record in the compare table.
     * @param int $id1 Id of the first card
     * @param int $id1 Id of the second card
     * @param int $val1 Internal value of the first card
     * @param int $val2 Internal value of the second card
     */
    private function addCompare($id1, $id2, $val1, $val2) {
        $point = 0;
        if ($val1 > $val2) {
            $point = 1;
        } else if ($val1 < $val2) {
            $point = -1;
        }
        DB::table('card_compares')->insert(
            array(
                'card_1_id' => $id1,
                'card_2_id' => $id2,
                'point' => $point
            )
        );
    }
}
