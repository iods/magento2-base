<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 * https://github.com/augustash/deployer-magento2-recipe
 */
declare(strict_types=1);

namespace Iods\Base\Helper\Config;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\App\State;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Module\ModuleListInterface;

class Module extends AbstractHelper
{
    const MODULE_NAME = 'Iods_Core';
    const MODULE_CONFIG_PATH = 'iods_core';

    protected DirectoryList $_directoryList;

    protected ModuleListInterface $_moduleList;

    protected ProductMetadataInterface $_productMetaData;

    protected State $_state;

    public function __construct(
        Context $context,
        DirectoryList $directoryList,
        ModuleListInterface $moduleList,
        ProductMetadataInterface $productMetadata,
        State $state
    ) {
        $this->_directoryList = $directoryList;
        $this->_moduleList = $moduleList;
        $this->_productMetaData = $productMetadata;
        $this->_state = $state;

        parent::__construct($context);
    }

    public function getMagentoMode(): string
    {
        // return the application deploy mode
        return $this->_state->getMode();
    }

    public function getModuleVersion(): string
    {
        // this is one way to get our version.
        $code = 'Iods_Core';
        $info = $this->_moduleList->getOne($code);
        return $info['setup_version'];
    }

    public function getMagentoVersion(): string
    {
        // get the Magento version running
        return $this->_productMetaData->getVersion();
    }

    public function getMagentoEdition(): string
    {
        // get the Magento edition (EE/CE)
        return $this->_productMetaData->getEdition();
    }

    public function getMagentoInstallPath(): string
    {
        return $this->_directoryList->getRoot();
    }
}