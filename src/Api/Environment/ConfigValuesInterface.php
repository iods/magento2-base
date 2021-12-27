<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Core\Api\Environment;

use Iods\Core\Model\ConfigValueSet;

interface ConfigValuesInterface
{
    public function create();

    public function getConfigValuesByEnvironment(string $environment): ConfigValueSet;

    public function withConfigValuesForEnvironment(ConfigValueSet $configValues, string $environment);
}