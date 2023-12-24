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

namespace Iods\Base\Helper;

class Log extends AbstractHelper
{
    /**
     * @param $method
     * @param $message
     * @return bool
     */
    public function logError($method = null, $message = null): bool
    {
        return $this->printToLog('error', "$method :: $message");
    }

    /**
     * Function to print to a log.
     * @param $file
     * @param $message
     * @return bool
     */
    public function printToLog($file = null, $message = null): bool
    {
        return $this->_writeToLog($file, $message);
    }

    /**
     * Writes a message to a log.
     * @param $file
     * @param $message
     * @return bool
     */
    private function _writeToLog($file = null, $message = null): bool
    {
        try {
            $now = $this->_object_manager->get(Date::class)->getDateNow()->format("Y-m-d h:i:s A T");
            $logfile = $this->_object_manager->get(File::class)->getRootPath() . "/var/log/iods/$file.log";

            return error_log("[$now] " . $message . "\n", 3, $logfile);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
