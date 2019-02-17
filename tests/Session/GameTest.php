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

        $game = new Game($caller);

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

        $this->assertTrue($game->check($card, $caller));
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

        $game = new Game($caller);

        $card->expects($this->atLeastOnce())
            ->method('isFullyMarked')
            ->will($this->returnValue(false));

        $this->assertFalse($game->check($card, $caller));
    }
}
