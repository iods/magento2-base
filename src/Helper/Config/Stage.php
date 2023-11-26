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

class Stage
{
    public const MODULE_NAME = 'Iods_Base';

    /*
     * Each class holds each environment's settings. Each environment
     * is then set to an app mode. If no app mode is set the environment
     * setting is therefore not applied.
     *
     * Individual classes hold custom functions loaded with the codebase
     * specific to the environment they are needed and will only run
     * if the scope is applied to it.
     */
    public const CONFIG_XML_ENVIRONMENT = 'STAGE';
}
