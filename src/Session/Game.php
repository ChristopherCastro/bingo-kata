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
     * Game constructor.
     *
     * @param \Bingo\Entity\CallerInterface $caller
     */
    public function __construct(CallerInterface $caller)
    {
        $this->setCaller($caller);
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
     * @param array $data
     */
    public function onPlayerBingo(PlayerInterface $player, array $data = []): void
    {
        $winner = $this->check($player->getCard(), $this->getCaller());

        if ($winner) {
            $this->emit('Game.winner', ['player' => $player]);
        }
    }
}
