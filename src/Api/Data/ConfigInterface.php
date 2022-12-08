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

namespace Iods\Base\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Interface ConfigInterface
 * @package Iods\Base\Api\Data
 */
interface ConfigInterface extends ExtensibleDataInterface
{
    public const ENVIRONMENT_DEVELOPMENT = 'development';
    public const ENVIRONMENT_LOCAL = 'local';
    public const ENVIRONMENT_PRODUCTION = 'production';
    public const ENVIRONMENT_STAGING = 'staging';

    public const MODULE_CACHE_TAG = 'iods_base_cache';
    public const MODULE_CONFIG_PATH = 'iods_base';
    public const MODULE_NAME = 'Iods_Base';
    public const MODULE_SQL_UPDATE_LIMIT = 50000;

    public const XML_PATH_API_URL = 'api_url';
    public const XML_PATH_API_MODE = 'mode';
    public const XML_PATH_DEBUG = 'iods/general/debug';
    public const XML_PATH_DEFAULT_PATTERN = 'iods/general/%s';
    public const XML_PATH_EXPORT = 'iods/';
    public const XML_PATH_LIVE_API_KEY = 'live_api_key';
    public const XML_PATH_MODULE_ENABLE = 'iods/general/enable';
    public const XML_PATH_MODULE_VERSION = 'iods/general/version';
    public const XML_PATH_TEST_API_KEY = 'test_api_key';


    /**
     * @return string
     */
    public function getApiUrl(): string;

    /**
     * @return string
     */
    public function getApiToken(): string;

    /**
     * @return string
     */
    public function getNotificationUrl(): string;

    /**
     * @return string
     */
    public function getPaymentLimits(): string;
}

    /**
     * Creates a config value.
     * @return mixed
     */
    // public function create();

    /**
     * Deletes a config value.
     * @param string $key
     * @param int|null $scopeId
     * @param string $scope
     * @return void
     */
    public function delete(string $key, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): void;

    /**
     * Returns the store ids in an array. (with or without the default)
     * @param bool $withDefault
     * @param bool $active
     * @return array
     */
    public function getAllStoreIds(bool $withDefault = false, bool $active = true): array;

    /**
     * Returns the API key for a specific store.
     * @param int|null $storeId
     * @return string
     */
    public function getApiKey(int $storeId = null): string;

    /**
     * Returns the sites base url.
     * @param string $type
     * @return string
     */
    public function getBaseUrl(string $type = UrlInterface::URL_TYPE_WEB): string;

    /**
     * Returns the configuration value based on the provided params.
     * @param string $key
     * @param int|null $scopeId
     * @param string $scope
     * @return string|null
     */
    public function getConfig(string $key, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): ?string;

    /**
     * Returns the configuration value based on the provided params from the database.
     * @param string $key
     * @param int|null $scopeId
     * @param string $scope
     * @return string
     */
    public function getConfigFromDatabase(string $key, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): string;

    /**
     * Returns the config set based on the environment provided.
     * @param string $environment
     * @return mixed
     */
    public function getConfigsFromEnvironment(string $environment): mixed;

    /**
     * Returns the path for the config values key.
     * @param string $key
     * @return mixed
     */
    public function getConfigPath(string $key): mixed;

    /**
     * Returns the current currency code used.
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
     * Returns the current edition Magento is running on.
     * @return string
     */
    public function getMagentoEdition(): string;

    /**
     * @return string
     */
    public function getMagentoInstallPath(): string;

    /**
     * Returns the application deploy mode.
     * @return string
     */
    public function getMagentoMode(): string;

    /**
     * Returns the current version Magento is running on.
     * @return string
     */
    public function getMagentoVersion(): string;

    /**
     * Returns the current stable version of the module.
     * @return string|null
     */
    public function getModuleVersion(): ?string;

    /**
     * Returns the current or specified store scope.
     * @param int|null $storeId
     * @return StoreInterface
     */
    // public function getStore(int $storeId = null): StoreInterface;

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
     * Returns the limit for
     * @return int
     */
    public function getUpdateSqlLimit(): int;

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
    // public function isDebugLog(): bool;

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
    // public function isEmpty(): bool;

    /**
     * Returns what API mode the module is in.
     * @param int|null $storeId
     * @return bool
     */
    // public function isLiveMode(int $storeId = null): bool;

    /**
     * Saves a config value.
     * @param string $key
     * @param string $value
     * @param int|null $scopeId
     * @param string $scope
     * @return void
     */
    public function save(string $key, string $value, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): void;
}
