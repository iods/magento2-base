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

use DateTime;
use Exception;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Throwable;

class Date extends AbstractHelper
{
    protected Log $_log;

    protected ObjectManagerInterface $_objectManager;

    protected TimezoneInterface $_timezone;

    public function __construct(
        Context $context,
        Log $log,
        ObjectManagerInterface $objectManager,
        TimezoneInterface $timezone
    ) {
        parent::__construct($context, $objectManager);
        $this->_log = $log;
        $this->_timezone = $timezone;
    }

    /**
     * Returns a given date using \DateTime.
     * @param $date
     * @return DateTime
     * @throws Exception
     */
    public function getDate($date = null): DateTime
    {
        return $this->_timezone->date(new DateTime($date));
    }

    /**
     * Returns a given date, in a desired format.
     * @param null $date
     * @param string $format
     * @return string
     * @throws Exception
     */
    public function getDateFormatted($date = null, string $format = "M j, Y"): string
    {
        return $this->getDate($date)->format($format);
    }

    /**
     * Returns the current date.
     * @return DateTime
     */
    public function getDateNow(): DateTime
    {
        return $this->_timezone->date();
    }

    /**
     * Returns true if the current date is within the range of provided dates.
     * @param $from
     * @param $to
     * @return bool
     */
    public function isWithinRange($from = null, $to = null): bool
    {
        try {
            $after = $this->isAfter($from);
            $before = $this->isBefore($to);
            $range = $after && $before;
        } catch (Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
            $range = false;
        } finally {
            return $range;
        }
    }

    /**
     * Returns true if the date provided is after the current one.
     * @param $date
     * @return bool
     */
    private function isAfter($date = null): bool
    {
        $now = $this->getDateNow()->format('Y-m-d');
        return !isset($date) || strtotime($now) >= strtotime($date);
    }

    /**
     * Returns true if the date provided is before the current one.
     * @param $date
     * @return bool
     */
    private function isBefore($date = null): bool
    {
        $now = $this->getDateNow()->format('Y-m-d');
        return !isset($date) || strtotime($now) <= strtotime($date);
    }
}
