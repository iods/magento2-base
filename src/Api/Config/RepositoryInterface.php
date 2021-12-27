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

namespace Iods\Core\Api\Config;

use Exception;
use Iods\Core\Model\Config;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Config Repository Interface
 * @package Iods\Core\Api\Config
 */
interface RepositoryInterface
{
    public const MODULE_NAME              = 'Iods_Core';
    public const XML_PATH_API_MODE        = 'mode';
    public const XML_PATH_DEBUG           = 'iods/general/debug';
    public const XML_PATH_DEFAULT_PATTERN = 'iods/general/%s';
    public const XML_PATH_EXPORT          = 'iods/';
    public const XML_PATH_LIVE_API_KEY    = 'live_api_key';
    public const XML_PATH_MODULE_ENABLE   = 'iods/general/enable';
    public const XML_PATH_MODULE_VERSION  = 'iods/general/version';
    public const XML_PATH_TEST_API_KEY    = 'test_api_key';

    /**
     * Creates a config value.
     * @return mixed
     */
    public function create();

    /**
     * Deletes a config value.
     * @param string $key
     * @param int|null $scopeId
     * @param string $scope
     */
    public function delete(string $key, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): void;

    /**
     * Saves a config value.
     * @param string $key
     * @param string $value
     * @param int|null $scopeId
     * @param string $scope
     */
    public function save(string $key, string $value, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): void;

    /**
     * @param bool $withDefault
     * @param bool $active
     * @return array
     */
    public function getAllStoreIds(bool $withDefault = false, bool $active = true): array;

    /**
     * @param null $storeId
     * @return string
     * @throws Exception
     */
    public function getApiKey($storeId = null): string;

    /**
     * @param string $type
     * @return string
     * @throws NoSuchEntityException
     */
    public function getBaseUrl(string $type = UrlInterface::URL_TYPE_WEB): string;

    /**
     * Returns a config value based on specific parameters.
     * @param string $key
     * @param int|null $scopeId
     * @param string $scope
     * @return string|null
     */
    public function getConfig(string $key, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): ?string;

    /**
     * Returns a config value from the database.
     * @param string $path
     * @param int|null $id
     * @param string $scope
     * @return string
     */
    public function getConfigFromDatabase(string $path, int $id = null, string $scope = ScopeInterface::SCOPE_STORES): string;

    /**
     * Returns the path for the config key.
     * @param string $key
     * @return mixed
     */
    public function getConfigPath(string $key);

    /**
     * Returns a value set based on the environment given.
     * @param string $environment
     * @return mixed
     */
    public function getConfigValuesByEnvironment(string $environment);

    /**
     * @param $path
     * @param null $scope
     * @return Config
     */
    public function getConfigValueByPath($path, $scope = null): Config;

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getCurrentCurrency(): string;

    /**
     * Returns the stores default store ID as int.
     * @param int $websiteId
     * @return int
     * @throws LocalizedException
     */
    public function getDefaultStoreId(int $websiteId): int;

    /**
     * Returns the stores default website ID as int.
     * @return int
     */
    public function getDefaultWebsiteId(): int;

    /**
     * Returns the current edition (EE or CE) Magento is running on.
     * @return string
     */
    public function getMagentoEdition(): string;

    /**
     * Returns the current version running on Magento.
     * @return string
     */
    public function getMagentoVersion(): string;

    /**
     * Returns the current prod version of the module.
     * @return string
     */
    public function getModuleVersion(): string;

    /**
     * Returns the scope code.
     * @return int
     */
    public function getScopeCode(): int;

    /**
     * Returns the scope type.
     * @return string
     */
    public function getScopeType(): string;

    /**
     * Returns the current or specified store scope.
     * @param int|null $storeId
     * @return StoreInterface
     */
    public function getStore(int $storeId = null): StoreInterface;

    /**
     * Returns the current store id.
     * @return int
     * @throws NoSuchEntityException
     */
    public function getStoreId(): int;

    /**
     * Returns a string with the active store name.
     * @param int $storeId
     * @return string
     * @throws NoSuchEntityException
     */
    public function getStoreName(int $storeId): string;

    /**
     * @return int
     */
    public function getUpdateSqlLimit(): int;

    /**
     * Returns configuration values as the Config Values provider.
     * @return mixed
     */
    public function getValues();

    /**
     * Returns the active website ID.
     * @return int
     * @throws NoSuchEntityException
     */
    public function getWebsiteId(): int;

    /**
     * Returns true if debug logging is enabled.
     * @return bool
     */
    public function isDebugLog(): bool;

    /**
     * Returns true or false whether the module is enabled.
     * @param int|null $storeId
     * @param string $scope
     * @return bool
     */
    public function isEnabled(int $storeId = null, string $scope = ScopeInterface::SCOPE_STORE): bool;

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Returns what API mode the module is in.
     * @param int|null $storeId
     * @return bool
     */
    public function isLiveMode(int $storeId = null): bool;

    /**
     * @return bool
     */
    public function isNull(): bool;

    /**
     * @param Config $configValue
     * @return $this
     */
    public function withConfigValue(Config $configValue): self;

    /**
     * Returns list of config values with their environment.
     * @param $configValues
     * @param string $environment
     * @return mixed
     */
    public function withConfigValuesForEnvironment($configValues, string $environment);
}
