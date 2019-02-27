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
use Bingo\Entity\PlayerInterface;
use Bingo\Event\EmitterInterface;
use Bingo\Event\ListenerInterface;

/**
 * Represents a particular bingo session.
 */
interface GameInterface extends ListenerInterface, EmitterInterface
{
    /**
     * Register a new participant.
     *
     * @param \Bingo\Entity\PlayerInterface $player
     */
    public function addPlayer(PlayerInterface $player): void;

    /**
     * Sets caller instance for this game session.
     *
     * @param \Bingo\Entity\CallerInterface $caller
     */
    public function setCaller(CallerInterface $caller): void;

    /**
     * Gets caller instance for this game session.
     *
     * @return \Bingo\Entity\CallerInterface
     */
    public function getCaller(): CallerInterface;

    /**
     * Gets session winner if exists.
     *
     * @return \Bingo\Entity\PlayerInterface|null
     */
    public function getWinner(): ?PlayerInterface;

    /**
     * Sets winner player for this game session.
     *
     * @param \Bingo\Entity\PlayerInterface $player
     */
    public function setWinner(PlayerInterface $player): void;

    /**
     * Whether ALL numbers in the given card were called by $caller.
     *
     * @param \Bingo\Card\CardInterface $card The card to check
     * @param \Bingo\Entity\CallerInterface $caller Caller instance being use in this game session
     * @return bool True if ALL numbers in $card were called, False otherwise
     */
    public function check(CardInterface $card, CallerInterface $caller): bool;
}
