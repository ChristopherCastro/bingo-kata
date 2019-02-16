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
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testCard()
    {
        $player = new Player();
        $card = $this->createMock(CardInterface::class);
        $player->setCard($card);

        $this->assertSame($card, $player->getCard());
    }
}
