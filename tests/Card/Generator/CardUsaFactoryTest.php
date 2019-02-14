<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author   Christopher Castro <chris@quickapps.es>
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Test\Card\Generator;

use Bingo\Card\CardUsa;
use Bingo\Card\Generator\CardUsaFactory;
use PHPUnit\Framework\TestCase;

class CardUsaFactoryTest extends TestCase
{

    /**
     * ## Scenario:
     *
     * - Given I have a Bingo card generator
     * - When I generate a Bingo card
     * - Then -> \Test\Card\CardUsaTest::*
     */
    public function testBuildValidCard()
    {
        $factory = new CardUsaFactory();

        $this->assertInstanceOf(CardUsa::class, $factory->build());
    }
}
