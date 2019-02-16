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
 * Objects implementing this interface can listen for events.
 *
 * The `listeners` method is used to notify the emitters what methods should
 * be called when an event is triggered.
 */
interface ListenerInterface
{
    /**
     * Returns a list of all listeners and their callable functions.
     *
     * ### Example:
     *
     * ```php
     *  public function listeners()
     *  {
     *      return [
     *          'Order.placed' => 'onOrderPlaced',
     *          'Order.completed' => 'onOrderCompleted',
     *      ];
     *  }
     * ```
     *
     * @return array
     */
    public function listeners(): array;
}
