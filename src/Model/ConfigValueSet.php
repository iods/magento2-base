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

namespace Iods\Core\Model;

use Iods\Core\Api\ConfigValueSetInterface;
use Iods\Core\Model\Environment\Scope;

class ConfigValueSet implements ConfigValueSetInterface, \IteratorAggregate
{
    private array $_values = [];

    public static function create(): self
    {
        return new self;
    }

    public static function of(array $configValues): self
    {
        $instance = new self;

        foreach ($configValues as $cv) {
            if (!$cv instanceof ConfigValue) {
                throw new \InvalidArgumentException(sprintf(
                    'Members of %s must be instances of %s, got %s',
                    self::class,
                    ConfigValue::class,
                    gettype($cv)
                ));
            }
            $instance->_addConfigValue($cv);
        }

        return $instance;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->_values);
    }

    public function getConfigValueByPath($path, Scope $scope = null): ConfigValue
    {
        $scope = $scope ?? new Scope();
        $empty = (new ConfigValue($path, null))->withScope($scope);
        return $this->_values[$this->_getConfigValueUniqueKey($empty)] ?? $empty;
    }

    public function isEmpty(): bool
    {
        return empty($this->_values);
    }

    public function withConfigValue(ConfigValue $configValue): self
    {
        $instance = clone $this;
        $instance->_addConfigValue($configValue);
        return $instance;
    }

    private function _addConfigValue(ConfigValue $configValue)
    {
        $this->_values[$this->_getConfigValueUniqueKey($configValue)] = $configValue;
    }

    private function _getConfigValueUniqueKey(ConfigValue $configValue): string
    {
        return join('/', [
            $configValue->getScope()->getScopeType(),
            $configValue->getScope()->getScopeCode(),
            $configValue->getPath()
        ]);
    }
}