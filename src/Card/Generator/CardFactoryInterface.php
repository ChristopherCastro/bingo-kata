<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author   Christopher Castro <chris@quickapps.es>
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Bingo\Card\Generator;

use Bingo\Card\CardInterface;

/**
 * Bingo cards generator. Every card generator must implement this interface.
 */
interface CardFactoryInterface
{

    /**
     * Creates a bingo card.
     *
     * @return \Bingo\Card\CardInterface New card instance
     */
    public function build(): CardInterface;
}
