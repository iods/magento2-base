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

namespace Iods\Core\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;

class BypassTwoFactorAuth
{
    private ScopeConfigInterface $_scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
    }

    /*
     * IF TFA module is disabled, return true to bypass all
     * 2FA. Else, return original result.
     */
    public function afterTfaIsGranted(TfaSession $subject, $result): bool
    {
        return !$this->_scopeConfig->isSetFlag('twofactorauth/general/enable') ? true : $result;
    }
}