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

use Iods\Core\Api\ConfigValueInterface;
use Iods\Core\Model\Environment\Scope;

class ConfigValue implements ConfigValueInterface
{
    private string $_path;

    private Scope $_scope;

    private string $_value;

    public function __construct($path, $value)
    {
        $this->_path = $path;
        $this->_value = $value;
    }

    public function isNull(): bool
    {
        return $this->_value === null;
    }

    public function getPath(): string
    {
        return $this->_path;
    }

    public function getScope(): Scope
    {
        return $this->_scope ?? new Scope();
    }

    public function withScope(Scope $scope): ConfigValue
    {
        $result = clone $this;
        $result->_scope = $scope;
        return $result;
    }

     public function getValue()
     {
         return $this->_value;
     }
}