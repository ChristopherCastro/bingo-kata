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

use PHPUnit\Framework\TestCase;
use Test\Double\Event\DummyEmitter;

class EmitterAwareTraitTest extends TestCase
{

    public function testAttach()
    {
        $listener = $this->createMock(ListenerInterface::class);
        $emitter = new DummyEmitter();
        $emitter->attachListener($listener);

        $this->assertEquals([$listener], array_values($emitter->attachedListeners()));
    }

    public function testEmit()
    {
        $listener = $this->createMock(ListenerInterface::class);
        $listener->expects($this->atLeastOnce())
            ->method('implementedEvents')
            ->will($this->returnValue(['Dummy.event' => 'dummyHandler']));

        $emitter = new DummyEmitter();
        $emitter->attachListener($listener);

        $emitter->emit('Dummy.event');
    }
}
