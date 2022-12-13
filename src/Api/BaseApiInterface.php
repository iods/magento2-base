<?php
/**
 * Special handling of different core APIs for testing services in Magento 2.
 *
 * @package   Iods\Connect
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2022, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Base\Api;

/**
 * Interface BaseApiInterface
 * Support to the Magento API for all services concerning the requests.
 * @package Iods\Base\Api
 */
interface BaseApiInterface
{
    /**
     * Returns the current Magento engine version.
     * @return string
     */
    public function getVersion(): string;
}