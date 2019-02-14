<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author   Christopher Castro <chris@quickapps.es>
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Bingo\Card;

/**
 * Represents a bingo card.
 *
 * A card is represented as a collection of "lines" (sets of integers and/or nils).
 * This "line" representation allows to handle sets of cells depending on the type of game
 * being played. For instance, USA uses "column lines", UK uses "row lines".
 */
interface CardInterface
{
    /**
     * Returns values for a specific line.
     *
     * @param mixed $index Line index
     * @return array[int|null] Null indicates an empty cell
     */
    public function getLine($index): array;

    /**
     * Returns values of a specific line.
     *
     * @param mixed $index Line index to set
     * @param array[int|null] Line values to set, null indicates an empty cell
     * @return void
     */
    public function setLine($index, array $values = []): void;
}
