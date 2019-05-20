<?php
declare(strict_types=1);
require_once './src/Game.php';

$config = require_once './config.php';

(new Game($config))->start();