<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author   Christopher Castro <chris@quickapps.es>
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Bingo\Entity;

use Bingo\Card\CardInterface;
use Bingo\Event\EmitterAwareTrait;
use Bingo\Session\GameInterface;

class Player implements PlayerInterface
{
    use EmitterAwareTrait;

    /**
     * Player's card.
     *
     * @var \Bingo\Card\CardInterface
     */
    protected $card;

    /**
     * Player constructor.
     *
     * @param \Bingo\Card\CardInterface $card
     * @param \Bingo\Session\GameInterface $game Game context
     */
    public function __construct(CardInterface $card, GameInterface $game)
    {
        $this->setCard($card);
        $this->attachListener($game);
    }

    /**
     * {@inheritdoc}
     */
    public function listeners(): array
    {
        return [
            'Game.call' => 'onGameCallNumber',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCard(): CardInterface
    {
        return $this->card;
    }

    /**
     * {@inheritdoc}
     */
    public function setCard(CardInterface $card): void
    {
        $this->card = $card;
    }

    /**
     * Triggered every time game calls a number.
     *
     * After marking, if player's card is fully marked a "bingo" event will be triggered.
     *
     * @param \Bingo\Session\GameInterface $game
     * @param array $data
     */
    public function onGameCallNumber(GameInterface $game, array $data = []): void
    {
        if (isset($data['number'])) {
            if ($this->getCard()->markNumber($data['number']) &&
                $this->getCard()->isFullyMarked()
            ) {
                $this->emit('Player.bingo');
            }
        }
    }
}
