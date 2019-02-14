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

class Caller implements CallerInterface
{

    /**
     * Available numbers to call.
     *
     * @var array
     */
    protected $numbers = [];

    /**
     * Caller constructor.
     */
    public function __construct()
    {
        $this->numbers = range(1, 75);
        shuffle($this->numbers);
    }

    /**
     * @inheritdoc
     */
    public function call(): int
    {
        return array_pop($this->numbers);
    }
}
