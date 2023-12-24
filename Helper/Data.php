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

<<<<<<< HEAD:Helper/Data.php
use Iods\Base\Helper\Base;
=======
use Iods\Base\Helper\BaseHelper;
>>>>>>> ef6260fbcfa374b042cc55bf7fb5033ae052f56f:src/Helper/Data.php
use Magento\Backend\App\Config;
use Magento\Backend\App\ConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Iods\Core\Helper
 */
class Data extends Base
{
    const MODULE_CONFIG_PATH = 'base';

    /**
     * @TODO write a description for the method.
     * @param $path
     * @param $scope_code
     * @return bool
     */
    public function getConfigFlag($path = null, $scope_code = null): bool
    {
        try {
            $is_set = $this->scopeConfig->isSetFlag($path, ScopeInterface::SCOPE_STORE, $scope_code);
        } catch (\Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
            $is_set = false;
        } finally {
            return $is_set;
        }
    }

    /**
     * @TODO write a description for the method.
     * @param $path
     * @param $scope_code
     * @return mixed|null
     */
    public function getConfigValue($path = null, $scope_code = null): mixed
    {
        try {
            $value = $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $scope_code);
        } catch (\Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
            $value = null;
        } finally {
            return $value;
        }
    }

    /**
     * @TODO write a description for the method.
     * @param $field
     * @param $scope_value
     * @param string $scope_type
     * @return array|mixed
     */
    public function getConfigsValue($field, $scope_value = null, string $scope_type = ScopeInterface::SCOPE_STORE): mixed
    {
        if ($scope_value === null && !$this->isArea()) {

            /** @var Config $_config */
            $this->_config = $this->_object_manager->get(ConfigInterface::class);
            return $this->_config->getValue($field);
        }
        // return $this->_config->getValue($field, $scope_type, $scope_value);
        return $this->scopeConfig->getValue($field, $scope_type, $scope_value);
    }



    public function getBaseConfig($code = '', $storeId = '')
    {
        $code = ($code !== '') ? '/' . $code : '';
        return $this->getConfigsValue(static::MODULE_CONFIG_PATH . '/base_config' . $code, $storeId);
    }


    public function getModuleConfig($field = '', $storeId = '')
    {
        $field = ($field !== '') ? '/' . $field : '';
        return $this->getConfigsValue(static::MODULE_CONFIG_PATH . $field, $storeId);
    }




    public function getWebsiteConfig($configField, $website = null)
    {
        return $this->scopeConfig->getValue(
            $configField,
            ScopeInterface::SCOPE_WEBSITE,
            $website
        );
    }


}
