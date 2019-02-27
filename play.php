<?php
require __DIR__ . '/vendor/autoload.php';

use Bingo\Entity\Caller;
use Bingo\Entity\Player;
use Bingo\Card\CardUsa;
use Bingo\Session\Game;

$game = new Game(new Caller());
$maxPlayers = rand(5, 10);

for ($i = 0; $i < $maxPlayers; $i++) {
    $player = new Player(new CardUsa(), $game);
    $game->addPlayer($player);
}

foreach ($game->play() as $roundInfo) {
    list($roundNumber, $calledNUmber) = $roundInfo;
    echo sprintf("- Playing round: %d\n", $roundNumber);
    $winner = $game->getWinner();

    echo sprintf("  - Called number: %d\n", $calledNUmber);

    if ($winner) {
        echo sprintf("  - There is a winner!: %s\n", spl_object_id($winner));
    } else {
        echo sprintf("  - There were no winners in this round\n");
    }
}

