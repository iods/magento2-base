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

namespace Iods\Base\Api;

use Magento\Store\Model\ScopeInterface;

/**
 * Interface ConfigRepositoryInterface
 * @package Iods\Base\Api
 */
interface ConfigRepositoryInterface
{
    /**
     * Creates a config value.
     * @param string $key
     * @param string $value
     * @param int|null $scopeId
     * @param string $scope
     * @return void
     */
    // public function create(string $key, string $value, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): void;

    /**
     * Deletes a config value.
     * @param string $key
     * @param int|null $scopeId
     * @param string $scope
     * @return void
     */
    public function delete(string $key, int $scopeId = null, string $scope = ScopeInterface::SCOPE_STORE): void;

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
