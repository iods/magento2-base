<?php
/**
 * Base module container for extending and testing general functionality across Magento 2.
 *
 * @package   Iods\Base
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2022, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Base\Logger;

use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Logger\Handler\Base;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Monolog\Logger;

class Handler extends Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * Log file name
     * @var string
     */
    protected $fileName = '/var/log/iods/base.log';

    public function __construct(
        DateTime $dateTime,
        DriverInterface $fileSystem,
        $fileName = null,
        $filePath = null
    ) {
        $filename = 'iods-' . $dateTime->gmtDate('d-m=Y', $dateTime->timestamp()) . '.log';
        parent::__construct($fileSystem, $filePath, '/var/log/' . $filename);
    }
}
