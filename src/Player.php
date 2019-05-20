<?php

class Player
{

    public $pool;
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setPool($pool)
    {
        $this->pool = $pool;
    }

    public function play(array $playerPool, array $playPool, array $mainPool)
    {
        $firstTile = $playPool[0];
        $lastTile = $playPool[count($playPool) - 1];

        list($tileToPlay, $playPosition, $playerPool, $mainPool) = $this->findTileToPlay($firstTile, $lastTile, $playerPool, $mainPool);
        return [$tileToPlay, $playPosition, $playerPool, $mainPool];
    }

    protected function findTileToPlay(array $firstTile, array $lastTile, array $playerPool, array $mainPool)
    {
        $playTileFound = false;
        $tileToPlay = $playPosition = null;
        foreach ($playerPool as $index => $playerTile) {
            if ($playerTile[0] == $firstTile[0]) {
                $tileToPlay = [$playerTile[1], $playerTile[0]];
                $playPosition = 'beginning';
                $playTileFound = true;
            } elseif ($playerTile[1] == $firstTile[0]) {
                $tileToPlay = [$playerTile[0], $playerTile[1]];
                $playTileFound = true;
                $playPosition = 'beginning';
            } elseif ($playerTile[0] == $lastTile[1]) {
                $tileToPlay = [$playerTile[0], $playerTile[1]];
                $playTileFound = true;
                $playPosition = 'end';
            } elseif ($playerTile[1] == $lastTile[1]) {
                $tileToPlay = [$playerTile[1], $playerTile[0]];
                $playTileFound = true;
                $playPosition = 'end';
            }

            if ($playTileFound) {
                unset($playerPool[$index]);
                break;
            }
        }

        if ($playTileFound) {
            return [$tileToPlay, $playPosition, $playerPool, $mainPool];
        }

        if (count($mainPool) > 0) {
            $tileFromMainPool = array_splice($mainPool, 0, 1);
            $playerPool = array_merge($playerPool, $tileFromMainPool);
            return $this->findTileToPlay($firstTile, $lastTile, $playerPool, $mainPool);
        }else if (count($mainPool) == 0) {
            return [$tileToPlay, $playPosition, $playerPool, $mainPool];
        }
    }
}