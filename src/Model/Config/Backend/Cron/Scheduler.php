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

namespace Iods\Core\Model\Config\Backend\Cron;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\App\Config\ValueFactory as ConfigValueFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Scheduler extends Value
{
    const CRON_STRING_PATH = 'crontab/iods/jobs/iods_cron_indexes_check';

    protected ConfigValueFactory $_configValueFactory;

    protected string $_runModelPath;

    public function __construct(
        AbstractResource $abstractResource = null,
        AbstractDb $abstractDb = null,
        ConfigValueFactory $configValueFactory,
        Context $context,
        Registry $registry,
        ScopeConfigInterface $scopeConfig,
        TypeListInterface $typeList,
        array $data = []
    ) {
        $this->_runModelPath = '';
        $this->_configValueFactory = $configValueFactory;
        parent::__construct(
            $context,
            $registry,
            $scopeConfig,
            $typeList,
            $abstractResource,
            $abstractDb,
            $data
        );
    }


    /**
     * @throws AlreadyExistsException
     */
    public function afterSave(): Scheduler
    {
        $expiring = $this->getData('groups/database/groups/adminhtml/fields/frequency/value');
        try {
            $this->_configValueFactory->create()->getFieldsetDataValue(
                self::CRON_STRING_PATH,
                'path'
            )->setValue(
                $expiring
            )->setPath(
                self::CRON_STRING_PATH
            )->save();
        } catch (\Exception $e) {
            throw new AlreadyExistsException(__('Cannot save this cron expression.'));
        }

        return parent::afterSave();
    }
}