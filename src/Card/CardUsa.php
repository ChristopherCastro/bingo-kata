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
 * Represents a card for playing US-bingo.
 */
class CardUsa implements CardInterface
{

    /**
     * Lines collection.
     *
     * @var array
     */
    protected $lines = [];

    /**
     * Holds a plain list of every number in this card.
     *
     * @var array[int]
     */
    protected $numbers = [];

    /**
     * List of marked numbers until now.
     *
     * @var array[int]
     */
    protected $marked = [];

    /**
     * Cells per line.
     *
     * @var int
     */
    protected static $lineLength = 5;

    /**
     * Lines definition rules when building a new card.
     *
     * @var array
     * @see self::randomLine()
     */
    protected static $linesDefinition = [
        'B' => ['lowerBound' => 1, 'upperBound' => 15, 'empty' => false],
        'I' => ['lowerBound' => 16, 'upperBound' => 30, 'empty' => false],
        'N' => ['lowerBound' => 31, 'upperBound' => 45, 'empty' => 2],
        'G' => ['lowerBound' => 46, 'upperBound' => 60, 'empty' => false],
        'O' => ['lowerBound' => 61, 'upperBound' => 75, 'empty' => false],
    ];

    /**
     * Constructs a random card.
     */
    public function __construct()
    {
        foreach (static::$linesDefinition as $index => $rule) {
            $this->setLine(
                $index,
                $this->randomLine($rule['lowerBound'], $rule['upperBound'], $rule['empty'])
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * {@inheritdoc}
     */
    public function getLine($index): array
    {
        return $this->lines[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function setLine($index, array $values = []): void
    {
        $this->lines[$index] = $values;
    }

    /**
     * {@inheritdoc}
     */
    public function numbers(): array
    {
        if (empty($this->numbers)) {
            foreach ($this->getLines() as $index => $cells) {
                $this->numbers = array_merge($this->numbers, $cells);
            }

            $this->numbers = array_filter($this->numbers);
        }

        return $this->numbers;
    }

    /**
     * {@inheritdoc}
     */
    public function markNumber(int $number): bool
    {
        if (in_array($number, $this->numbers())) {
            $this->marked[] = $number;

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getMarkedNumbers(): array
    {
        return $this->marked;
    }

    /**
     * Returns a randomly generated line.
     *
     * @param int $lowerBound Lowest possible random value
     * @param int $upperBound Highest possible random value
     * @param bool|int $empty An integer value indicates which cell (index) should be marked as empty,
     *  boolean false indicates there are no empty cells
     * @return array[int|null]
     */
    protected function randomLine(int $lowerBound, int $upperBound, $empty): array
    {
        $fullRange = range($lowerBound, $upperBound);
        shuffle($fullRange);
        $line = array_slice($fullRange, 0, static::$lineLength);

        if (is_int($empty) && array_key_exists($empty, $line)) {
            $line[$empty] = null;
        }

        return $line;
    }
}
