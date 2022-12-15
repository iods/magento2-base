<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 * https://github.com/augustash/deployer-magento2-recipe
 */
declare(strict_types=1);

namespace Iods\Base\Helper\Config;

class Module
{
    const MODULE_NAME = 'Iods_Base';

    const CONFIG_XML_PATH_SECTION = 'base';
    const CONFIG_XML_PATH_GROUP = 'base_config';
}
