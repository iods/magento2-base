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

use Magento\Framework\UrlInterface;

interface ConfigScopeInterface
{
    public function getAllStoreIds(bool $withDefault = false, bool $active = true): array;

    public function getBaseUrl(string $type = UrlInterface::URL_TYPE_WEB): string;

    public function getCurrentCurrency(): string;

    public function getDefaultStoreId(int $websiteId): int;

    public function getDefaultWebsiteId(): int;

    public function getMagentoEdition(): string;

    public function getMagentoVersion(): string;

    public function getSingleStoreMode(): bool;

    public function getStoreId(): int;

    public function getStoreName(int $storeId): string;

    public function getWebsiteId(): int;
}