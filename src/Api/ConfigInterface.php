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
use Magento\Store\Model\ScopeInterface;

interface ConfigInterface
{
    public function isEnabled(int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): bool;

    public function getModuleVersion();

    public function getConfig(string $key, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): ?string;

    public function getConfigFromDatabase(string $path, int $id = null, string $scope = ScopeInterface::SCOPE_STORES): string;

    public function getConfigPath(string $key);

    public function getEavRowIdFieldName(): ?string;

    public function getRowIdAvailability(): bool;

    public function getUpdateSqlLimit(): int;

    public function delete(string $key, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): void;

    // public function save(string $key, string $value, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): void;

    public function save(ConfigValue $configValue);
}
