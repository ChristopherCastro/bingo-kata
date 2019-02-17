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
 * Simple implementation for `ListenerInterface`.
 */
trait EmitterAwareTrait
{
    /**
     * List of listeners attached to this class.
     *
     * @var array[\Bingo\Event\ListenerInterface]
     */
    protected $listeners;

    /**
     * {@inheritdoc}
     *
     * Callable functions will receive two arguments:
     *
     * - subject object (emitter) as first argument
     * - array of additional data being send by the subject, it may be empty
     */
    public function emit(string $event, array $data = []): void
    {
        foreach ($this->listeners as $listener) {
            $implementedEvents = $listener->listeners();

            if (isset($implementedEvents[$event]) &&
                method_exists($listener, $implementedEvents[$event])
            ) {
                $method = $implementedEvents[$event];
                $listener->{$method}($this, $data);
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
}
