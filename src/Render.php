<?php

class Render{

    public function renderToStdOut(array $pool)
    {
        if (count($pool) == 1) {
            $this->renderInitialMessage($pool);
        }

    }

    public function renderPlayerMove(string $playerName, array $playerTile, array $connectingTile)
    {
        printf("%s plays <%s> to connect to tile <%s> on the board \n", $playerName, implode(":", $playerTile), implode(":", $connectingTile));
    }

    public function renderBoardState(array $pool)
    {
        $tilesOnBoard = "";
        foreach ($pool as $tile){
            $tilesOnBoard .= "<".implode(":", $tile)."> ";
        }
        printf("Board is now: %s \n", $tilesOnBoard);
    }

    public function renderInitialMessage(array $pool)
    {
        printf("Game starting with first tile: <%s> \n\n", implode(":", $pool[0]));
    }

    public function renderWinnerMessage(string $playerName)
    {
        printf("\n%s has won! \n", $playerName);
    }

    public function renderGameDrawnMessage(array $players)
    {
        printf("\nGame has been drawn! \n");
        foreach ($players as $player) {
            printf("%s has %s tiles left \n", $player->name, count($player->pool));
        }
    }
}