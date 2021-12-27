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

namespace Iods\Core\Model\Environment;

use Iods\Core\Api\Environment\ConfigValuesInterface;
use Iods\Core\Model\ConfigValueSet;

class ConfigValues implements ConfigValuesInterface
{
    private array $_environments = [];

    public function create(): self
    {
        return new self;
    }

    public function getConfigValuesByEnvironment(string $environment): ConfigValueSet
    {
        return $this->_environments[$environment] ?? ConfigValueSet::create();
    }

    public function withConfigValuesForEnvironment(ConfigValueSet $configValues, string $environment): ConfigValues
    {
        $cloned = clone $this;
        $cloned->_environments[$environment] = $configValues;
        return $cloned;
    }
}