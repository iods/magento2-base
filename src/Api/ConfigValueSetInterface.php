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

namespace Iods\Core\Api;

use Iods\Core\Model\ConfigValue;
use Iods\Core\Model\Environment\Scope;

interface ConfigValueSetInterface
{
    public function isEmpty(): bool;

    public function getConfigValueByPath($path, Scope $scope = null): ConfigValue;

    public function withConfigValue(ConfigValue $configValue): self;
}