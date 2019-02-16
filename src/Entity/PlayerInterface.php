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

use Bingo\Card\CardInterface;
use Bingo\Event\EmitterInterface;
use Bingo\Event\ListenerInterface;

/**
 * Represents a single player able to participate in a bingo game session.
 */
interface PlayerInterface extends ListenerInterface, EmitterInterface
{

}
