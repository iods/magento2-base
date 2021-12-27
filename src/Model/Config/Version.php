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

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Module\Manager;
use Magento\Framework\Module\ModuleList;
use Magento\Framework\Module\ResourceInterface;
use Magento\Framework\Registry;
use Safe\Exceptions\JsonException;

class Version extends Value
{
    const IODS_VENDOR = 'Iods';

    protected ModuleList $_moduleList;

    protected Manager $_moduleManager;

    protected ResourceInterface $_moduleResource;

    public function __construct(
        AbstractResource $abstractResource = null,
        AbstractDb $abstractDb = null,
        Context $context,
        Manager $manager,
        ModuleList $moduleList,
        Registry $registry,
        ResourceInterface $resource,
        ScopeConfigInterface $scopeConfig,
        TypeListInterface $typeList,
        array $data = []
    ) {
        $this->_moduleList = $moduleList;
        $this->_moduleManager = $manager;
        $this->_moduleResource = $resource;

        parent::__construct(
            $context,
            $registry,
            $scopeConfig,
            $typeList,
            $abstractResource,
            $abstractDb,
            $data,
        );
    }


    /**
     * @throws LocalizedException
     * @throws JsonException
     */
    public function afterLoad()
    {
        $this->setValue($this->_getCustomModules());
    }


    /**
     * @throws LocalizedException
     * @throws JsonException
     */
    protected function _getCustomModules(): string
    {
        $result = [];
        $modules = $this->_moduleList->getNames();
        if ($modules === null) {
            throw new LocalizedException(__('Could not load Iods module list.'));
        }

        foreach ($modules as $module) {
            if (strpos($module, self::IODS_VENDOR) !== false) {
                $result[] = [
                    'name' => $module,
                    'version' => $this->_moduleResource->getDbVersion($module),
                    'active' => (int)$this->_moduleManager->isEnabled($module)
                ];
            }
        }

        return \Safe\json_encode($result);
    }
}
