<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author   Christopher Castro <chris@quickapps.es>
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Bingo\Event;

/**
 * Objects implementing this interface can emit events.
 */
interface EmitterInterface
{
    /**
     * Emits the given event to every attached listener subscribed to this event.
     *
     * Listener methods will receive:
     *
     * - Subject/context as first argument; an instance of `\Bingo\Event\EmitterInterface`
     * - Any additional argument passed to `emit()` will be directly mapped to listener method
     *
     * ### Example:
     *
     * Within an object named `Order` implementing `EmitterInterface`,
     *
     * ```php
     * $this->>emit('Order.completed', $user, time());
     * ```
     *
     * Listener methods to handle this event should look as follow:
     *
     * ```php
     * public function onOrderCompleted(ListenerInterface $order, $user, $when): void
     * {
     *     // do something
     * }
     * ```
     *
     * @param string $event Event to dispatch
     * @param mixed ...$data Any value you wish to be transported with this event to listener callable
     */
    public function emit(string $event, ...$data): void;

    /**
     * Registers a new listener object.
     *
     * @param \Bingo\Event\ListenerInterface $listener
     */
    public function attachListener(ListenerInterface $listener): void;
}
