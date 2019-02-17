<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author   Christopher Castro <chris@quickapps.es>
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Bingo\Entity;

use Bingo\Entity\Error\NoMoreNumbersException;

class Caller implements CallerInterface
{

    /**
     * Available numbers to call.
     *
     * @var array[int]
     */
    protected $numbers = [];

    /**
     * Called numbers until now.
     *
     * @var array[int]
     */
    protected $called = [];

    /**
     * Caller constructor.
     */
    public function __construct()
    {
        $this->numbers = range(1, 75);
        shuffle($this->numbers);
    }

    /**
     * {@inheritdoc}
     */
    public function call(): int
    {
        $number = array_pop($this->numbers);

        if ($number === null) {
            throw new NoMoreNumbersException('No more numbers available to call.');
        }

        $this->called[] = $number;

        return $number;
    }

    /**
     * {@inheritdoc}
     */
    public function called(): array
    {
        return $this->called;
    }

    /**
     * {@inheritdoc}
     */
    public function validateNumbers(array $numbers): bool
    {
        return empty(array_diff($numbers, $this->called()));
    }
}
