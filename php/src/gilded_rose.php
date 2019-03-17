<?php

class GildedRose {

    private $items;

    function __construct($items) {
        $this->items = $items;
    }

    function update_quality() {
        //Setting some constants for easy adjusting if needed
        //Normal items decrease by 1 until sell in >= 0
        $regular = 1; 
        //After sell in < 0, decreases twice as fast
        $afterRegular = $regular * 2;
        //Conjured decrease twice as normal
        $conjured = $regular * 2; 
        //After sell in < 0, decreases twice as fast (like normal items)
        $afterConjured = $conjured * 2; 
        //Max quality if 50
        $max = 50;
        foreach ($this->items as $item) {
            if (strpos($item->name,'Sulfuras')=== false) {
                //Decrease days left
                $item->sell_in = $item->sell_in - 1;
                
                if ($item->sell_in >= 0) {
                    if ($item->name != 'Aged Brie' and strpos($item->name,'Backstage passes')=== false) {
                        if ($item->quality > 0)
                        {
                            if (strpos($item->name,'Conjured')!== false)
                            {
                                if ($item->quality >= $conjured) {
                                    $item->quality = $item->quality - $conjured;
                                } else $item->quality = 0;
                            } else {
                                if ($item->quality >= $regular) {
                                    $item->quality = $item->quality - $regular;
                                } else $item->quality = 0;
                            }
                        }
                        
                    } else if ($item->quality < $max){
                        if ($item->quality + $regular <= $max) {
                            $item->quality = $item->quality + $regular;
                            if (strpos($item->name,'Backstage passes')!== false) {
                                if ($item->sell_in < 11) {
                                    if ($item->quality + $regular <= $max) {
                                        $item->quality = $item->quality + $regular;
                                    } else $item->quality = $max;
                                }
                                if ($item->sell_in < 6) {
                                    if ($item->quality + $regular <= $max) {
                                        $item->quality = $item->quality + $regular;
                                    } else $item->quality = $max;
                                }
                            } 
                        } else $item->quality = $max;
                    } 
                } else {
                    if ($item->name != 'Aged Brie') {
                        if (strpos($item->name,'Backstage passes')=== false) {
                            if ($item->quality > 0) {
                                if (strpos($item->name,'Conjured')!== false){
                                    if ($item->quality >= $afterConjured) {
                                        $item->quality = $item->quality - $afterConjured;
                                    } else $item->quality = 0;
                                }  else {
                                    if ($item->quality >= $afterRegular) {
                                        $item->quality = $item->quality - $afterRegular;
                                    } else $item->quality = 0;
                                }
                            }
                        } else {
                            $item->quality = 0;
                        }
                    } else if ($item->quality < $max){
                        if ($item->quality + $afterRegular <= $max) {
                            //By the logic of the previous code, Age Brie quality increases twice as fast after sell in < 0
                            $item->quality = $item->quality + $afterRegular;
                        } else $item->quality = $max;
                    }
                }
            }
        }
    }
}

class Item {

    public $name;
    public $sell_in;
    public $quality;

    function __construct($name, $sell_in, $quality) {
        $this->name = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;
    }

    public function __toString() {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }

}

