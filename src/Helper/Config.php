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

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Config
 * @package Iods\Core\Helper
 */
class Config extends AbstractHelper
{
    public function getConfig($config)
    {
        // return $this->scopeConfig->getValue($config, ScopeInterface::SCOPE_STORE);
        return $this->scopeConfig->getValue($config, ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }
}