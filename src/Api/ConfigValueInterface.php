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

use Iods\Core\Model\Environment\Scope;

interface ConfigValueInterface
{
    public function isNull(): bool;

    public function getPath(): string;

    public function getScope();

    public function withScope(Scope $scope);

    public function getValue();
}