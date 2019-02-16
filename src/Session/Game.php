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
use Bingo\Event\ListenerInterface;

class Game implements GameInterface
{
    /**
     * {@inheritdoc}
     */
    public function emit(string $event, array $data = []): void
    {
        // TODO: Implement emit() method.
    }

    /**
     * {@inheritdoc}
     */
    public function attachListener(ListenerInterface $listener): void
    {
        // TODO: Implement attachListener() method.
    }

    /**
     * {@inheritdoc}
     */
    public function check(CardInterface $card, CallerInterface $caller): bool
    {
        // TODO: Implement check() method.
    }

    /**
     * {@inheritdoc}
     */
    public function listeners(): array
    {
        // TODO: Implement listeners() method.
    }
}
