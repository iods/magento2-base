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

namespace Iods\Core\Model\Config;

use Iods\Core\Api\ConfigScopeInterface;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\Website;

class Scope implements ConfigScopeInterface
{
    private array $_allStoreIds = [0 => null, 1 => null];

    protected ProductMetadataInterface $_productMetaData;

    protected array $_storeCode = [];

    protected StoreManagerInterface $_storeManager;

    public function __construct(
        ProductMetadataInterface $productMetadata,
        StoreManagerInterface $storeManager
    ) {
        $this->_productMetaData = $productMetadata;
        $this->_storeManager = $storeManager;
    }

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

    public function getBaseUrl(string $type = UrlInterface::URL_TYPE_WEB): string
    {
        return $this->_storeManager->getStore()->getBaseUrl($type);
    }

    public function getCurrentCurrency(): string
    {
        return $this->_storeManager->getStore()->getCurrentCurrencyCode();
    }

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

    public function getDefaultWebsiteId(): int
    {
        $websiteId = 0;
        $storeView = $this->_storeManager->getDefaultStoreView();
        if ($storeView) {
            $websiteId = $storeView->getWebsiteId();
        }
        return $websiteId;
    }

    public function getMagentoEdition(): string
    {
        return $this->_productMetaData->getEdition();
    }

    public function getMagentoVersion(): string
    {
        return $this->_productMetaData->getVersion();
    }

    public function getSingleStoreMode(): bool
    {
        return $this->_storeManager->isSingleStoreMode();
    }

    public function getStoreId(): int
    {
        return $this->_storeManager->getStore()->getId();
    }

    public function getStoreName(int $storeId): string
    {
        if (!array_key_exists($storeId, $this->_storeCode)) {
            $this->_storeCode[$storeId] = $this->_storeManager->getStore($storeId)->getName();
        }
        return $this->_storeCode[$storeId];
    }

    public function getWebsiteId(): int
    {
        return $this->_storeManager->getStore()->getWebsiteId();
    }
}