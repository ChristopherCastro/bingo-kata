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

/**
 * Represents a bingo caller.
 */
interface CallerInterface
{
    /**
     * Calls a randomly selected ball number.
     *
     * @throws \Bingo\Entity\Error\NoMoreNumbersException
     */
    public function call(): int;

    /**
     * Retrieves a list of every number called until now.
     *
     * @return array[int]
     */
    public function called(): array;
}
