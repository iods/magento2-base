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

namespace Iods\Base\Helper\Service;

use Iods\Base\Helper\AbstractHelper;
use Iods\Base\Helper\Log;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\ObjectManagerInterface;
use Throwable;
use Zend_Db_Statement_Interface;

/**
 * Class Database
 * @package Iods\Base\Helper
 */
class Database extends AbstractHelper
{
    /** @var Log */
    protected Log $_log;

    /** @var ResourceConnection */
    protected ResourceConnection $_resource;

    /**
     * @param Context $context
     * @param Log $log
     * @param ObjectManagerInterface $objectManager
     * @param ResourceConnection $resource
     */
    public function __construct(
        Context $context,
        Log $log,
        ObjectManagerInterface $objectManager,
        ResourceConnection $resource
    ) {
        parent::__construct($context, $objectManager);
        $this->_log = $log;
        $this->_resource = $resource;
    }

    /**
     * Returns the result of a query() method with the table name prefixes, using X handling.
     * @param $name
     * @return string|null
     * @see https://meetanshi.com/blog/get-table-name-with-prefix-magento-2/
     */
    public function getTableName($name = null): ?string
    {
        try {
            $table_name = $this->_resource->getTableName($name);
            $exists = $this->_resource->getConnection()->isTableExists($table_name);
        } catch (Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
            $table_name = null;
            $exists = false;
        } finally {
            return $exists ? $table_name : null;
        }
    }

    /**
     * Returns the result of a Magento fetchAll() method using X handling.
     * @param $sql
     * @param int $limit
     * @return array|null
     */
    public function runFetchAll($sql, int $limit = 0): ?array
    {
        $sql .= ($limit > 0) ? " LIMIT $limit" : '';

        try {
            $result = $this->_resource->getConnection()->fetchAll($sql);
        } catch (Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
            $result = null;
        } finally {
            return $result;
        }
    }

    /**
     * Returns the result of a Magento fetchOne() method using X handling.
     * @param $sql
     * @return string|null
     */
    public function runFetchOne($sql): ?string
    {
        try {
            $result = $this->_resource->getConnection()->fetchOne($sql);
        } catch (Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
            $result = null;
        } finally {
            return $result;
        }
    }

    /**
     * Returns the result of a Magento fetchRow() method using X handling.
     * @param $sql
     * @return mixed
     */
    public function runFetchRow($sql): mixed
    {
        try {
            $result = $this->_resource->getConnection()->fetchRow($sql);
        } catch (Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
            $result = null;
        } finally {
            return $result;
        }
    }

    /**
     * Returns the result of a Magento query() method using X handling.
     * @param $sql
     * @return Zend_Db_Statement_Interface|null
     */
    public function runQuery($sql): ?Zend_Db_Statement_Interface
    {
        try {
            $result = $this->_resource->getConnection()->query($sql);
        } catch (Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
            $result = null;
        } finally {
            return $result;
        }
    }
}
