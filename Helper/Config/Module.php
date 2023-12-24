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

namespace Iods\Base\Helper\Config;

class Module
{
    public const MODULE_NAME = 'Iods_Base';

    public const CONFIG_XML_PATH_SECTION = 'base';
    public const CONFIG_XML_PATH_GROUP = 'base_config';
}
