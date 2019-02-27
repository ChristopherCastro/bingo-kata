<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author   Christopher Castro <chris@quickapps.es>
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Bingo\Session;

use Bingo\Card\CardInterface;
use Bingo\Entity\CallerInterface;
use Bingo\Entity\Player;
use Bingo\Entity\PlayerInterface;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * ## Scenario:
     *
     * - Given a player calls Bingo after all numbers on their card have been called
     * - When I check the card
     * - Then the player is the winner
     */
    public function testOnPlayerCallsBingoValidCard()
    {
        $card = $this->createMock(CardInterface::class);
        $caller = $this->createMock(CallerInterface::class);
        $player = $this->createMock(PlayerInterface::class);

        $card->expects($this->atLeastOnce())
            ->method('isFullyMarked')
            ->will($this->returnValue(true));

        $card->expects($this->atLeastOnce())
            ->method('getMarkedNumbers')
            ->will($this->returnValue([5, 6, 4, 3, 1, 2]));

        $caller->expects($this->atLeastOnce())
            ->method('validateNumbers')
            ->with($this->equalTo([5, 6, 4, 3, 1, 2]))
            ->will($this->returnValue(true));

        $player->expects($this->atLeastOnce())
            ->method('getCard')
            ->will($this->returnValue($card));

        $game = new Game($caller);
        $game->onPlayerBingo($player);

        $this->assertSame($player, $game->getWinner());
    }

    /**
     * ## Scenario:
     *
     * - Given a player calls Bingo before all numbers on their card have been called
     * - When I check the card
     * - Then the player is not the winner
     */
    public function testOnPlayerCallsBingoInvalidCard()
    {
        $card = $this->createMock(CardInterface::class);
        $caller = $this->createMock(CallerInterface::class);
        $player = $this->createMock(PlayerInterface::class);

        $card->expects($this->atLeastOnce())
            ->method('isFullyMarked')
            ->will($this->returnValue(false));

        $player->expects($this->atLeastOnce())
            ->method('getCard')
            ->will($this->returnValue($card));

        $game = new Game($caller);
        $game->addPlayer($player);
        $game->onPlayerBingo($player);

        $this->assertEmpty($game->getWinner());
    }

    /**
     * Ensures that player receives event messages from the game.
     */
    public function testGameToPlayerCommunication()
    {
        $caller = $this->createMock(CallerInterface::class);
        $player = $this->createMock(Player::class);


        $player->expects($this->atLeastOnce())
            ->method('implementedEvents')
            ->will($this->returnValue(['Game.winner' => 'onGameWinner']));

        $player->expects($this->atLeastOnce())
            ->method('onGameWinner');

        $game = new Game($caller);
        $game->addPlayer($player);

        $game->emit('Game.winner', $player);
    }
}
