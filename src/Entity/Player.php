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
use Bingo\Event\ListenerInterface;

class Player implements PlayerInterface
{
    /**
     * Player's card.
     *
     * @var \Bingo\Card\CardInterface
     */
    protected $card;

    /**
     * List of listeners attached to this class.
     *
     * @var array[\Bingo\Event\ListenerInterface]
     */
    protected $listeners;

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
     * {@inheritdoc}
     */
    public function emit(string $event, array $data = []): void
    {
        foreach ($this->listeners as $listener) {
            $implementedEvents = $listener->listeners();

            if (isset($implementedEvents[$event]) &&
                method_exists($listener, $implementedEvents[$event])
            ) {
                $method = $implementedEvents[$event];
                $listener->{$method}($data);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attachListener(ListenerInterface $listener): void
    {
        $id = spl_object_id($listener);
        $this->listeners[$id] = $listener;
    }

    /**
     * {@inheritdoc}
     */
    public function listeners(): array
    {
        return [
            'Game.call',
        ];
    }
}
