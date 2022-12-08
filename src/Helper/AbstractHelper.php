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

use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\DataObject;
use Throwable;

/**
 * Class AbstractHelper
 * @package Iods\Base\Helper
 */
abstract class AbstractHelper extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var ObjectManagerInterface */
    protected ObjectManagerInterface $_object_manager;

    /**
     * @param Context $context
     * @param ObjectManagerInterface $object_manager
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $object_manager
    ) {
        parent::__construct($context);
        $this->_object_manager = $object_manager;
    }

    /**
     * specify the sort column and column direction
     * @param array $data
     * @param string $col
     * @param int $direction
     * @return void
     */
    public function getDataSortByColumn(array &$data = [], string $col = "qty", int $direction = SORT_DESC): void
    {
        $this->getDataSortByColumns($data, $col, $direction);
    }

    /**
     * specify the sort columns and direction
     * @param array $data
     * @param string $col
     * @param int $dir
     * @param string $colTwo
     * @param int $dirTwo
     * @return void
     */
    public function getDataSortByColumnsMultiple(array &$data = [], string $col = "qty", int $dir = SORT_DESC, string $colTwo = "qty", int $dirTwo = SORT_DESC): void
    {
        $this->getDataSortByColumns($data, $col, $dir, $colTwo, $dirTwo);
    }

    /**
     * presort some columns.
     * @param array $data
     * @param ...$args
     * @return void
     */
    public function getDataSortByColumns(array &$data = [], ...$args): void
    {
        $params = [];
        $is_empty = false;

        foreach ($args as $arg) {
            switch (true) {
                case is_string($arg):
                    $col = array_column($data, $arg);
                    switch (count($col) > 0) {
                        case true:
                            $params[] = $col;
                            $is_empty = false;
                            break;

                        case false:
                            $is_empty = true;
                            break;
                    }
                    break;
                case is_numeric($arg):
                    if (!$is_empty) $params[] = $arg;
                    break;
            }
        }

        if (!empty($params)) {
            $params[] = &$data;
            call_user_func_array('array_multisort', $params);
            $data = array_pop($params);
        }
    }

    /**
     * essentially is a custom-built object manager/factory
     * @param $class_name
     * @return mixed
     */
    public function buildClassObject($class_name = null): mixed
    {
        try {
            $object = $this->_object_manager->get($class_name);
        } catch (Throwable $e) {
            $object = $this->_object_manager->create(DataObject::class);
        } finally {
            return $object;
        }
    }

    /**
     * returns true, and some output (that is provided)
     * @param $output
     * @return bool
     */
    public function testOutput($output = null): bool
    {
        // in templates (knowing that you received it, and that it is not just
        // displaying, or that it aint there baby) this works really nice :)
        try {
            print_r($output);
            return true;
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * returns the value of a defined key from an array (very useful)
     * @param array $arr
     * @param int $k
     * @param $default
     * @return mixed
     */
    protected function _getArrayValue(array $arr = [], int $k = 0, $default = null): mixed
    {
        return $arr[$k] ?? $default;
    }
}
