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
use Bingo\Event\EmitterInterface;
use Bingo\Event\ListenerInterface;

/**
 * Represents a particular bingo session.
 */
interface GameInterface extends ListenerInterface, EmitterInterface
{
    /**
     * Whether ALL numbers in the given card were called by $caller.
     *
     * @param \Bingo\Card\CardInterface $card The card to check
     * @param \Bingo\Entity\CallerInterface $caller Caller instance being use in this game session
     * @return bool True if ALL numbers in $card were called, False otherwise
     */
    public function check(CardInterface $card, CallerInterface $caller): bool;
}
