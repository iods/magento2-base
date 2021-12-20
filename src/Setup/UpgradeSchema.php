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

namespace Iods\Core\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    // do I really need this right now?
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '0.1.1', '<')) {
            $installer = $setup;
            $installer->startSetup();
            $connection = $installer->getConnection();

            $connection->addColumn(
                'core_config_iods', 'iods_general',
                [
                    'type' => Table::TYPE_TEXT,
                    'comment' => 'General configuration for Iods extensions'
                ]);
            $connection->endSetup();
        }
    }
}