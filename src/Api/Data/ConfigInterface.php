<?php
/**
 * Base module container for extending and testing general functionality across Magento 2.
 *
 * @package   Iods\Base
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2023, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Base\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface ConfigInterface
 * @package Iods\Base\Api\Data
 */
interface ConfigInterface extends ExtensibleDataInterface
{
    public const MODULE_NAME = 'Iods_Base';
}
