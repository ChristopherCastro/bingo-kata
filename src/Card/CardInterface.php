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
     * Returns an array of every line being hold by this card.
     *
     * ## Example Output:
     *
     * For USA cards,
     *
     * ```php
     * [
     *   'B' => [13, 15, 14, 1, 2],
     *   'I' => [24, 30, 16, 20, 18],
     *   'N' => [42, 37, null, 43, 39],
     *   'G' => [57, 53, 50, 56, 48],
     *   'O' => [71, 67, 72, 62, 69],
     * ]
     * ```
     *
     * @return array Array of lines indexed by line's index
     */
    public function getLines(): array;

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

    /**
     * Retrieves a list of every number present in this card.
     *
     * @return array[int]
     */
    public function numbers(): array;

    /**
     * Marks the given number in this card if exists.
     *
     * @param int $number Number to be marked
     * @return bool True if number was marked, False if number was not
     * found in this card and thus not marked
     */
    public function markNumber(int $number): bool;

    /**
     * Gets a list of marked numbers in this card.
     *
     * @return array[int]
     */
    public function getMarkedNumbers(): array;

    /**
     * Whether this card has been fully marked.
     *
     * @return bool
     */
    public function isFullyMarked(): bool;
}
