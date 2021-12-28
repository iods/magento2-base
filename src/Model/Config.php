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

use Iods\Core\Api\ConfigInterface as ConfigRepositoryInterface;
use Iods\Core\Model\Environment\Scope;
use Magento\Config\Model\ResourceModel\Config as ConfigResource;
use Magento\Eav\Model\Entity;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Module\ModuleList;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\Website;

/**
 * Config Class
 * @package Iods\Core\Model\Config
 */
class Config implements ConfigRepositoryInterface
{
    /** @var array $_config */
    protected array $_config = [
        'api'              => ['path' => self::XML_PATH_API_URL],
        'api_messaging'    => ['path' => 'api_messaging'],
        'api_key'          => ['path' => self::XML_PATH_LIVE_API_KEY],
        'api_key_test'     => ['path' => self::XML_PATH_TEST_API_KEY],
        'application_key'  => ['path' => 'application_key'],
        'apiV1'            => ['path' => '/api/v1/'],
        'api_mode'         => ['path' => self::XML_PATH_API_MODE],
        'debug'            => ['path' => self::XML_PATH_DEBUG],
        'enabled'          => ['path' => self::XML_PATH_MODULE_ENABLE],
        'sql_update_limit' => ['path' => self::MODULE_SQL_UPDATE_LIMIT],
        'version'          => ['path' => self::XML_PATH_MODULE_VERSION]
    ];

    /** @var ConfigResource $_configResource */
    protected ConfigResource $_configResource;

    /** @var Entity $_entity */
    protected Entity $_entity;

    /** @var ModuleList $_moduleList */
    protected ModuleList $_moduleList;

    /** @var ModuleListInterface $_moduleListInterface */
    protected ModuleListInterface $_moduleListInterface;

    /** @var ProductMetadataInterface $_productMetaData */
    protected ProductMetadataInterface $_productMetaData;

    /** @var ScopeConfigInterface $_scopeConfig */
    protected ScopeConfigInterface $_scopeConfig;

    /** @var array $_storeCode */
    protected array $_storeCode = [];

    /** @var StoreManagerInterface $_storeManager */
    protected StoreManagerInterface $_storeManager;

    /** @var WriterInterface $_writer */
    protected WriterInterface $_writer;

    /** @var array|null[] $_allStoreIds */
    private array $_allStoreIds = [0 => null, 1 => null];

    /** @var EncryptorInterface $_encryptor */
    private EncryptorInterface $_encryptor;

    /** @var string $_value */
    private string $_value;

    public function __construct(
        ConfigResource $configResource,
        EncryptorInterface $encryptor,
        Entity $entity,
        ModuleListInterface $moduleListInterface,
        ProductMetadataInterface $productMetadata,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        WriterInterface $writer
    ) {
        $this->_configResource = $configResource;
        $this->_encryptor = $encryptor;
        $this->_entity = $entity;
        $this->_moduleListInterface = $moduleListInterface;
        $this->_productMetaData = $productMetadata;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->_writer = $writer;
    }

    /**
     * @return array
     */
    public static function all(): array
    {
        return [
            self::ENVIRONMENT_DEVELOPMENT,
            self::ENVIRONMENT_LOCAL,
            self::ENVIRONMENT_PRODUCTION,
            self::ENVIRONMENT_STAGING
        ];
    }

    /**
     * @inheritDoc
     */
    public function delete(string $key, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): void
    {
        $configPath = $this->_config[$key]['path'];
        $scope = $scope ?: ScopeInterface::SCOPE_STORES;
        $scopeId = $scopeId === null ? $this->_storeManager->getStore()->getId() : $scopeId;
        $this->_writer->delete($configPath, $scope, $scopeId);
    }

    /**
     * @inheritDoc
     */
    public function getAllStoreIds(bool $withDefault = false, bool $active = true): array
    {
        $cacheKey = ($withDefault) ? 1 : 0;

        if ($this->_allStoreIds[$cacheKey] === null) {
            $this->_allStoreIds[$cacheKey] = [];

            foreach ($this->_storeManager->getStores($withDefault) as $store) {
                /** @var Store $store */
                if ($active && !$store->isActive()) {
                    continue;
                }
                $this->_allStoreIds[$cacheKey][] = $store->getId();
            }
        }
        return $this->_allStoreIds[$cacheKey];
    }

    /**
     * @inheritDoc
     */
    public function getBaseUrl(string $type = UrlInterface::URL_TYPE_WEB): string
    {
        return $this->_storeManager->getStore()->getBaseUrl($type);
    }

    /**
     * @inheritDoc
     */
    public function getConfig(string $key, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): ?string
    {
        $config = '';

        if (isset($this->_config[$key]['path'])) {
            $configPath = $this->_config[$key]['path'];
            if ($scopeId === null) {
                $scopeId = $this->_storeManager->getStore()->getId();
            }
            if (isset($this->_config[$key]['read_from_db'])) {
                $config = $this->getConfigFromDatabase($configPath, $scopeId, $scope);
            } else {
                $config = $this->_scopeConfig->getValue($configPath, $scopeId, $scope);
            }
            if (isset($this->_config[$key]['encrypted']) && $this->_config[$key]['encrypted'] === true && $config) {
                $config = $this->_encryptor->decrypt($config);
            }
        }

        return $config;
    }

    /**
     * @inheritDoc
     */
    public function getConfigFromDatabase(string $path, int $id = null, string $scope = ScopeInterface::SCOPE_STORES): string
    {
        if ($scope == ScopeInterface::SCOPE_STORE) {
            $scope = ScopeInterface::SCOPE_STORES;
        }

        $conn = $this->_configResource->getConnection();
        if (!$conn) {
            return '';
        }

        $select = $conn->select()->from(
            $this->_configResource->getMainTable(),
            ['value']
        )->where(
            'path = ?',
            $path
        )->where(
            'scope = ?',
            $scope
        )->where(
            'scope_id = ?',
            $id
        );
        return $conn->fetchOne($select);
    }

    /**
     * @inheritDoc
     */
    public function getCurrentCurrency(): string
    {
        return $this->_storeManager->getStore()->getCurrentCurrencyCode();
    }

    /**
     * @inheritDoc
     */
    public function getConfigPath(string $key)
    {
        return $this->_config[$key]['path'];
    }

    /**
     * @inheritDoc
     */
    public function getDefaultStoreId(int $websiteId): int
    {
        $storeId = 0;

        /** @var Website $website */
        $website = $this->_storeManager->getWebsite($websiteId);

        if ($website instanceof Website) {
            $storeId = $website->getDefaultStore()->getId();
        }
        return $storeId;
    }

    /**
     * @inheritDoc
     */
    public function getDefaultWebsiteId(): int
    {
        $websiteId = 0;
        $storeView = $this->_storeManager->getDefaultStoreView();
        if ($storeView) {
            $websiteId = $storeView->getWebsiteId();
        }
        return $websiteId;
    }

    /**
     * @inheritDoc
     */
    public function getMagentoEdition(): string
    {
        return $this->_productMetaData->getEdition();
    }

    /**
     * @inheritDoc
     */
    public function getMagentoVersion(): string
    {
        return $this->_productMetaData->getVersion();
    }

    /**
     * @inheritDoc
     */
    public function getModuleVersion(): ?string
    {
        $module = $this->_moduleList->getOne(self::MODULE_NAME);
        return $module ? $module ['setup_version'] : null;
    }

    /**
     * @inheritDoc
     */
    public function getStoreId(): int
    {
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * @inheritDoc
     */
    public function getStoreName(int $storeId): string
    {
        if (!array_key_exists($storeId, $this->_storeCode)) {
            $this->_storeCode[$storeId] = $this->_storeManager->getStore($storeId)->getName();
        }
        return $this->_storeCode[$storeId];
    }

    /**
     * @inheritDoc
     */
    public function getUpdateSqlLimit(): int
    {
        return self::MODULE_SQL_UPDATE_LIMIT;
    }

    /**
     * @inheritDoc
     */
    public function getWebsiteId(): int
    {
        return $this->_storeManager->getStore()->getWebsiteId();
    }

    /**
     * @inheritDoc
     */
    public function isEnabled(int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): bool
    {
        return (bool) $this->getConfig('iods_core', $scopeId, $scope);
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->_value === null;
    }

    /**
     * @param $environment
     * @return bool
     */
    public static function isValid($environment): bool
    {
        return $environment === self::ENVIRONMENT_DEVELOPMENT ||
            $environment === self::ENVIRONMENT_LOCAL ||
            $environment === self::ENVIRONMENT_PRODUCTION ||
            $environment === self::ENVIRONMENT_STAGING;
    }

    /**
     * @inheritDoc
     */
    public function save(string $key, string $value, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): void
    {
        $configPath = $this->_config[$key]['path'];
        $scope = $scope ?: ScopeInterface::SCOPE_STORES;
        $scopeId = $scopeId === null ? $this->_storeManager->getStore()->getId() : $scopeId;
        if (isset($this->_config[$key]['encrypted']) && $this->_config[$key]['encrypted'] == true && $value) {
            $value = $this->_encryptor->encrypt($value);
        }
        $this->_writer->save($configPath, $value, $scope, $scopeId);
    }
}