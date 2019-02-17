<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author   Christopher Castro <chris@quickapps.es>
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Test\Entity;

use Bingo\Card\CardInterface;
use Bingo\Entity\Player;
use Bingo\Event\ListenerInterface;
use Bingo\Session\GameInterface;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testCard()
    {
        $card = $this->createMock(CardInterface::class);
        $game = $this->createMock(GameInterface::class);
        $player = new Player($card, $game);

        $this->assertSame($card, $player->getCard());
    }

    public function testEmit()
    {
        $card = $this->createMock(CardInterface::class);
        $game = $this->createMock(GameInterface::class);

        $player = new Player($card, $game);

        $game->expects($this->atLeastOnce())
            ->method('listeners')
            ->will($this->returnValue(['testEvent' => 'testEventHandler']));

        $player->emit('testEvent', ['testData' => 'dummy']);
    }
}
