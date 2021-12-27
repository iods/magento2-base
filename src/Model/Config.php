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

use Iods\Core\Api\Config\RepositoryInterface as ConfigRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Module\ModuleList;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\Website;

/**
 * Repository Class
 * @package Iods\Core\Model\Config
 */
class Config implements ConfigRepositoryInterface
{
    /** @var ModuleList $_moduleList */
    protected ModuleList $_moduleList;

    /** @var ProductMetadataInterface $_productMetaData */
    protected ProductMetadataInterface $_productMetaData;

    /** @var array $_storeCode */
    protected array $_storeCode = [];

    /** @var ScopeConfigInterface $_scopeConfig */
    protected ScopeConfigInterface $_scopeConfig;

    /** @var StoreManagerInterface $_storeManager */
    protected StoreManagerInterface $_storeManager;

    /** @var array|null[] $_allStoreIds */
    private array $_allStoreIds = [0 => null, 1 => null];

    public function __construct(
        ProductMetadataInterface $productMetadata,
        StoreManagerInterface $storeManager
    ) {
        $this->_productMetaData = $productMetadata;
        $this->_storeManager = $storeManager;
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
    public function getCurrentCurrency(): string
    {
        return $this->_storeManager->getStore()->getCurrentCurrencyCode();
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
    public function getWebsiteId(): int
    {
        return $this->_storeManager->getStore()->getWebsiteId();
    }
}