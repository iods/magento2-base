<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @version   100.1.1
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021-2022, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Core\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

/**
 * Class ErrorHandler
 * @package Iods\Core\Logger\Handler
 */
class ErrorHandler extends Base
{
    protected int $loggerType = Logger::DEBUG;

    protected string $fileName = '/var/log/Iods/exception.log';
}