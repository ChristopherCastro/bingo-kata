<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author   Christopher Castro <chris@quickapps.es>
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Test\Card;

use Bingo\Card\CardUsa;
use PHPUnit\Framework\TestCase;

class CardUsaTest extends TestCase
{

    /**
     * ## Scenario:
     *
     * - When I generate a Bingo card
     * - [Then the generated card has 25 unique spaces]
     *   - And column `$column` only contains numbers between `$lowerBound` and `$upperBound` inclusive
     *   - And the generated card has 1 FREE space in the middle
     */
    public function testUniqueSpaces()
    {
        $card = new CardUsa();
        $lines = $card->getLines();
        $numbers = [];

        foreach ($lines as $index => $cells) {
            $numbers = array_merge($numbers, $cells);
        }

        // 25 unique spaces
        $this->assertThat(
            $numbers,
            $this->logicalAnd(
                $this->equalTo(array_unique($numbers)),
                $this->countOf(25)
            )
        );
    }

    /**
     * ## Scenario:
     *
     * - When I generate a Bingo card
     * - Then the generated card has 25 unique spaces
     *   - [And column `$column` only contains numbers between `$lowerBound` and `$upperBound` inclusive]
     *   - And the generated card has 1 FREE space in the middle
     */
    public function testColumnsWithinRage()
    {
        $card = new CardUsa();
        $cases = [
            'B' => [1, 15], // index => lower, upper
            'I' => [16, 30],
            'N' => [31, 45],
            'G' => [46, 60],
            'O' => [61, 75],
        ];

        foreach ($cases as $lineIndex => $bounds) {
            $line = $card->getLine($lineIndex);
            $line = array_filter($line); // remove empty cells
            $validValues = range($bounds[0], $bounds[1]);
            $diff = array_diff($line, $validValues);

            $this->assertEmpty(
                $diff,
                sprintf('Line `%s` has some values out of range: [%s]', $lineIndex, implode(',', $diff))
            );
        }
    }

    /**
     * ## Scenario:
     *
     * - When I generate a Bingo card
     * - Then the generated card has 25 unique spaces
     *   - And column `$column` only contains numbers between `$lowerBound` and `$upperBound` inclusive
     *   - [And the generated card has 1 FREE space in the middle]
     */
    public function testFreeCellInTheMiddle()
    {
        $card = new CardUsa();
        $lines = $card->getLines();
        $middleLine = 'N';
        $middleCell = 2;

        foreach ($lines as $lineIndex => $cells) {
            foreach ($cells as $cellIndex => $cell) {
                if ($cell === null &&
                    $lineIndex !== $middleCell &&
                    $cellIndex !== $middleCell
                ) {
                    $this->fail(sprintf('Cell [%s, %d] is not allowed to be empty', $lineIndex, $cellIndex));
                }
            }
        }

        $this->assertEmpty($lines[$middleLine][$middleCell]);
    }
}
