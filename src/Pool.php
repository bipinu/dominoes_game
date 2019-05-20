<?php

class Pool
{
    protected $pool;

    public function __construct($tiles = null)
    {
    }

    public function createPool($maxDotsOnTile)
    {
        $this->pool = array();
        $outerCounter = 0;
        while ($outerCounter <= $maxDotsOnTile) {
            for ($counter = 0; $counter <= $maxDotsOnTile; $counter++) {
                if ($outerCounter > $counter){
                    continue;
                }
                $this->pool[] = [$outerCounter, $counter];
            }
            $outerCounter++;
        }
        return $this;
    }

    public function shuffle()
    {
        return shuffle($this->pool);
    }

    public function getPool()
    {
        return $this->pool;
    }

    public function drawPool($poolSize)
    {
        return array_splice($this->pool, 0, $poolSize);
    }

    public function drawTile($pool, $firstTile = false)
    {
        if($firstTile){
            $topTile = array_splice($pool, 0, 1);
            return [$topTile, $pool];
        }
    }
}