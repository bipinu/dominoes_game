<?php
require_once 'Player.php';
require_once 'Pool.php';
require_once 'Render.php';

class Game
{

    private $config;
    private $players;
    private $mainPool;
    private $playPool;
    private $render;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->players = $this->loadPlayers($this->config['player_count']);
        $this->mainPool = $this->loadPool($this->config['max_dots_on_tile']);
        $this->playPool = [];
        $this->render = new Render();
    }

    protected function loadPlayers(int $totalPlayers)
    {
        $players = [];
        for ($counter = 1; $counter <= $totalPlayers; $counter++) {
            $players["player{$counter}"] = new Player("player{$counter}");
        }

        return $players;
    }

    protected function loadPool(int $maxDotsOnTile)
    {
        return (new Pool())->createPool($maxDotsOnTile);
    }

    protected function setGameInMotion()
    {
        $this->mainPool->shuffle();
        foreach ($this->players as $player) {
            $player->setPool($this->mainPool->drawPool($this->config['player_pool_size']));
        }

        list($this->playPool, $this->mainPool) = $this->mainPool->drawTile($this->mainPool->getPool(), TRUE);
        $this->render->renderToStdOut($this->playPool);
    }

    protected function beginGameWithPlayers()
    {
        $gameOver = false;
        foreach ($this->players as $player) {
            list($tileToPlay, $playPosition, $player->pool, $this->mainPool) = $player->play($player->pool, $this->playPool, $this->mainPool);

            if($playPosition == 'beginning'){
                $this->render->renderPlayerMove($player->name, $tileToPlay, $this->playPool[0]);
                $this->playPool = array_merge([$tileToPlay], $this->playPool);
            }else if($playPosition == 'end'){
                $this->render->renderPlayerMove($player->name, $tileToPlay, $this->playPool[count($this->playPool) - 1]);
                $this->playPool = array_merge($this->playPool, [$tileToPlay]);
            }

            $this->render->renderBoardState($this->playPool);

            if(count($player->pool) == 0){
                $this->render->renderWinnerMessage($player->name);
                $gameOver = true;
                break;
            }
            if(count($this->mainPool) == 0){
                $this->render->renderGameDrawnMessage($this->players);
                $gameOver = true;
                break;
            }
        }

        if(!$gameOver){
            return $this->beginGameWithPlayers();
        }
    }

    public function start()
    {
        $this->setGameInMotion();
        $this->beginGameWithPlayers();
    }
}