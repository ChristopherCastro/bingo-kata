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
            ->method('numbers')
            ->will($this->returnValue([1, 2, 3, 4, 5, 6]));

        $card->expects($this->atLeastOnce())
            ->method('getMarkedNumbers')
            ->will($this->returnValue([5, 6, 4, 3, 1, 2]));

        $caller->expects($this->atLeastOnce())
            ->method('called')
            ->will($this->returnValue([3, 4, 2, 5, 1, 6]));

        $this->assertTrue($game->check($card, $caller));
    }
}
