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

/*
 * What are we doing here in this file?
 *
 * Managing common configuration settings used through Iods modules.
 */

use Magento\Config\Model\ResourceModel\Config as ConfigResource;
use Magento\Eav\Model\Entity;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config
{
    /*
     * Do all modules get this?
     */
    const MODULE_NAME = 'Iods_Core';

    /*
     * What is important about this?
     */
    const SQL_UPDATE_LIMIT = 50000;

    protected array $_config = [
        'api' => ['path' => 'iods/env/iods_api_url'],
        'api_messaging' => ['path' => 'iods_core/env/iods_api_url_messaging'],
        'app_key' => ['path' => 'iods/settings/app_key'],
        'apiV1' => ['path' => 'iods/env/iods_api_v1_url'],
        'enable_debug' => ['path' => 'iods/settings/enable_debug'],
        'iods_active' => ['path' => 'iods/settings/active'],
        'secret' => ['path' => 'iods/settings/secret','encrypted' => true]
    ];

    protected ConfigResource $_configResource;

    protected EncryptorInterface $_encryptor;

    protected Entity $_entity;

    protected ModuleListInterface $_moduleList;

    protected ProductMetadataInterface $_productMetadata;

    protected ScopeConfigInterface $_scopeConfig;

    // array of int and string?
    protected array $_storeCode = [];

    protected StoreManagerInterface $_storeManager;

    protected WriterInterface $_writer;

    public function __construct(
        ConfigResource $configResource,
        EncryptorInterface $encryptor,
        Entity $entity,
        ModuleListInterface $moduleList,
        ProductMetadataInterface $productMetadata,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        WriterInterface $writer
    ) {
        $this->_configResource = $configResource; // what and why?
        $this->_encryptor = $encryptor; // what and why?
        $this->_entity = $entity;
        $this->_moduleList = $moduleList;
        $this->_productMetadata = $productMetadata;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->_writer = $writer;
    }


    public function getConfig(string $key, int $id = null, string $scope = ScopeInterface::SCOPE_STORE)
    {
        $config = '';

        if (isset($this->_config[$key]['path'])) {
            $path = $this->_config[$key]['path'];
            if ($id === null) {
                ///
            }
        }
    }

}