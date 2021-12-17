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

namespace Iods\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function getConfigValue($configField, $store = null)
    {
        return $this->scopeConfig->getValue(
            $configField,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    public function getWebsiteConfigValue($configField, $website = null)
    {
        return $this->scopeConfig->getValue(
            $configField,
            \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE,
            $website
        );
    }
}