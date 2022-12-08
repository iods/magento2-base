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

namespace Iods\Base\Helper;

use Exception;
use Magento\Backend\App\Config;
use Magento\Backend\App\ConfigInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\State;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Data
 * @package Iods\Core\Helper
 */
class Data extends AbstractHelper
{
    const MODULE_CONFIG_PATH = 'iods_core';


    protected Config $_config;

    protected array $_isArea = [];

    protected ObjectManagerInterface $_objectManager;

    protected StoreManagerInterface $_storeManager;

    private $_utcConverter;

    private $_timezone;




    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager
    ) {
        $this->_objectManager = $objectManager;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }


    public function getGeneralConfig($code = '', $storeId = '')
    {
        $code = ($code !== '') ? '/' . $code : '';
        return $this->getConfigValue(static::MODULE_CONFIG_PATH . '/general' . $code, $storeId);
    }


    public function getModuleConfig($field = '', $storeId = '')
    {
        $field = ($field !== '') ? '/' . $field : '';
        return $this->getConfigValue(static::MODULE_CONFIG_PATH . $field, $storeId);
    }



    public function getWebsiteConfig($configField, $website = null)
    {
        return $this->scopeConfig->getValue(
            $configField,
            ScopeInterface::SCOPE_WEBSITE,
            $website
        );
    }




    public function getConfigValue($field, $scopeValue = null, $scopeType = ScopeInterface::SCOPE_STORE)
    {
        if ($scopeValue === null && !$this->isArea()) {
            /** @var Config $_config */
            if (!$this->_config) {
                $this->_config = $this->_objectManager->get(ConfigInterface::class);
            }
            return $this->_config->getValue($field);
        }
        return $this->scopeConfig->getValue($field, $scopeType, $scopeValue);
    }


    public function isAdmin(): bool
    {
        return $this->isArea(Area::AREA_ADMINHTML);
    }


    public function isArea($area = Area::AREA_FRONTEND)
    {
        if (!isset($this->_isArea[$area])) {
            /** @var State $state */
            $state = $this->_objectManager->get(State::class);
            try {
                $this->isArea[$area] = ($state->getAreaCode() == $area);
            } catch (Exception $e) {
                $this->_isArea[$area] = false;
            }
        }
        return $this->_isArea[$area];
    }
}