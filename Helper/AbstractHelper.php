<?php
/**
 * Base module container for extending and testing general functionality across Magento 2.
 *
 * @package   Iods\Base
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2023, Rye Miller (https://ryemiller.io)
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
    /**
     * @var ObjectManagerInterface
     */
    protected ObjectManagerInterface $_object_manager;

    /**
     * @param Context $context
     * @param ObjectManagerInterface $object_manager
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $object_manager
    ) {
        $this->_object_manager = $object_manager;
        parent::__construct($context);
    }

    /**
     * Returns the value of a defined key from an array.
     * @param array $arr
     * @param int $index
     * @param null $default
     * @return mixed|null
     */
    protected function _getArrayValue(array $arr = [], int $index = 0, $default = null): mixed
    {
        return $arr[$index] ?? $default;
    }

    /**
     * Returns an instance of the desired object; like a custom Object Manager.
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
     * @param float $num
     * @param int $dec
     * @param string $sep
     * @param string $sep_thousands
     * @return string
     */
    public function formatNumber(float $num = 0.00, int $dec = 2, string $sep = ".", string $sep_thousands = ","): string
    {
        return number_format($num, $dec, $sep, $sep_thousands);
    }

    /**
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
     * Presort any available columns before loading.
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
                    $column = array_column($data, $arg);
                    if (count($column) > 0) {
                        $params[] = $column;
                        $is_empty = false;
                    } else {
                        $is_empty = true;
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
     * Returns true if data is available to output and dumps the data.
     *
     * This is especially useful in templates (.phtml) because it both validates that
     * the information was received (bool) and able to render.
     * @param $output
     * @return bool
     */
    public function testOutput($output = null): bool
    {
        try {
            print_r($output);
            return true;
        } catch (Throwable $e) {
            return false;
        }
    }
}
