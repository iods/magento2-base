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

namespace Iods\Base\Helper\Config;

class Stage
{
    const MODULE_NAME = 'Iods_Base';

    /*
     * Each class holds each environment's settings
     * each environment is set to an app mode
     * if the app mode is not set the environment setting is not applied
     * 
     * each class holds custom functions loaded with the codebase but only
     * in the environment they are needed and will only run if the scope
     * is applied in it.
     */

    const CONFIG_XML_ENVIRONMENT = 'STAGE';
}
