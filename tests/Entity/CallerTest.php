<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author   Christopher Castro <chris@quickapps.es>
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Test\Entity;

use Bingo\Entity\Caller;
use PHPUnit\Framework\TestCase;

class CallerTest extends TestCase
{
    /**
     * ## Scenario:
     *
     * - Given I have a Bingo caller
     * - When I call a number
     * - Then the number is between 1 and 75 inclusive
     *
     * @return void
     */
    public function testCallWithinValidRange()
    {
        $caller = new Caller();
        $number = false;

        try {
            $number = $caller->call();
        } catch (\Exception $ex) {
            // catch
        }

        // TODO: study, unreliable as depends on random output
        $this->assertThat(
            $number,
            $this->logicalAnd(
                $this->greaterThanOrEqual(1),
                $this->lessThanOrEqual(75)
            )
        );
    }

    /**
     * ## Scenario:
     *
     * - Given I have a Bingo caller
     * - When I call a number 75 times
     * - Then all numbers between 1 and 75 are present AND no number has been called more than once
     *
     * @return void
     */
    public function testCallFullRangeNoRepetition()
    {
        $caller = new Caller();
        $fullRange = range(1, 75);
        $calledNumbers = [];

        for ($i = 1; $i <= 75; $i++) {
            try {
                $calledNumbers[] = $caller->call();
            } catch (\Exception $ex) {
                // catch
            }
        }

        // TODO: performance, avoid sort and try array_diff?
        sort($calledNumbers);
        $this->assertEquals($fullRange, $calledNumbers);
    }

    /**
     * @expectedException \Bingo\Entity\Error\NoMoreNumbersException
     */
    public function testCallOutOfNumbers()
    {
        $caller = new Caller();

        for ($i = 1; $i <= 76; $i++) {
            $caller->call();
        }
    }

    public function testCalledIsEmptyAtStart()
    {
        $caller = new Caller();
        $called = $caller->called();

        $this->assertEmpty($called);
    }

    /**
     * @depends testCallWithinValidRange
     * @depends testCallFullRangeNoRepetition
     * @depends testCallOutOfNumbers
     */
    public function testCalledConsistency()
    {
        $caller = new Caller();
        $max = 4;
        $called = [];

        for ($i = 0; $i < $max; $i++) {
            try {
                $called[] = $caller->call();
            } catch (\Exception $ex) {
                // catch
            }
        }

        $this->assertEquals($called, $caller->called());
    }

    public function testValidateNumbers()
    {
        $caller = new Caller();

        $this->assertTrue(
            $caller->validateNumbers([
                $caller->call(),
                $caller->call(),
                $caller->call(),
            ])
        );

        $this->assertFalse($caller->validateNumbers([100]));
    }
}
