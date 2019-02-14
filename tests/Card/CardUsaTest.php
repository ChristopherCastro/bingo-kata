<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author   Christopher Castro <chris@quickapps.es>
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Card;

use Bingo\Card\CardUsa;
use PHPUnit\Framework\TestCase;

class CardUsaTest extends TestCase
{

    /**
     * ## Scenario:
     *
     * - When I generate a Bingo card
     * - Then the generated card has 25 unique spaces
     *  - And column `$column` only contains numbers between `$lowerBound` and `$upperBound` inclusive
     *  - And the generated card has 1 FREE space in the middle
     */
    public function testValidCardStructure()
    {
        $card = new CardUsa();
    }
}
