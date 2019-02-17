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
use Bingo\Entity\Error\NoMoreNumbersException;
use Bingo\Entity\PlayerInterface;
use Bingo\Event\EmitterAwareTrait;

class Game implements GameInterface
{
    use EmitterAwareTrait;

    /**
     * Caller instance for this session.
     *
     * @var \Bingo\Entity\CallerInterface
     */
    protected $caller;

    /**
     * List of participants.
     *
     * @var \Bingo\Entity\PlayerInterface
     */
    protected $players = [];

    /**
     * Winner of this game session.
     *
     * @var \Bingo\Entity\PlayerInterface|null
     */
    protected $winner = null;

    /**
     * Game constructor.
     *
     * @param \Bingo\Entity\CallerInterface $caller
     */
    public function __construct(CallerInterface $caller)
    {
        $this->setCaller($caller);
    }

    /**
     * Starts playing.
     */
    public function play()
    {
        $round = 0;
        while (!$this->getWinner()) {
            $round++;
            $number = null;

            try {
                $number = $this->getCaller()->call();
                $this->emit('Game.call', $number);
            } catch (NoMoreNumbersException $ex) {
                // no more numbers and no winner
                break;
            }

            yield [$round, $number];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function listeners(): array
    {
        return [
            'Player.bingo' => 'onPlayerBingo',
        ];
    }

    public function addPlayer(PlayerInterface $player): void
    {
        $id = spl_object_id($player);
        $this->players[$id] = $player;

        $this->attachListener($this->players[$id]);
    }

    /**
     * {@inheritdoc}
     */
    public function getCaller(): CallerInterface
    {
        return $this->caller;
    }

    /**
     * {@inheritdoc}
     */
    public function setCaller(CallerInterface $caller): void
    {
        $this->caller = $caller;
    }

    /**
     * {@inheritdoc}
     */
    public function getWinner(): ?PlayerInterface
    {
        return $this->winner;
    }

    /**
     * {@inheritdoc}
     */
    public function setWinner(PlayerInterface $player): void
    {
        $this->winner = $player;
    }

    /**
     * {@inheritdoc}
     */
    public function check(CardInterface $card, CallerInterface $caller): bool
    {
        return $card->isFullyMarked() &&
            $caller->validateNumbers($card->getMarkedNumbers());
    }

    /**
     * Handles player's bingo call.
     *
     * Notifies every other player if given player is the winner of this session.
     *
     * @param \Bingo\Entity\PlayerInterface $player
     */
    public function onPlayerBingo(PlayerInterface $player): void
    {
        $winner = $this->check($player->getCard(), $this->getCaller());

        if ($winner) {
            $this->setWinner($player);
            $player->setWinner(true);
            $this->emit('Game.winner', $player);
        }
    }
}
