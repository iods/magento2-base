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

abstract class AbstractHelper extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected ObjectManagerInterface $_objectManager;


    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager
    ) {
        parent::__construct($context);
        $this->_objectManager = $objectManager;
    }

    // essentially is a custom-built object manager/factory
    public function generateClassObject($className = null)
    {
        // $o = $this->_objectManager->create(DataObject::class);
        try {
            $o = $this->_objectManager->get($className);
        } catch (Throwable $e) {
            $o = $this->_objectManager->create(DataObject::class);
        } finally {
            return $o;
        }
    }

    // specify the sort column and column direction
    public function getDataSortByColumn(&$data = [], $col = "qty", $dir = SORT_DESC)
    {
        $this->getDataSortByColumns($data, $col, $dir);
    }

    // specify the sort columns and direction
    public function getDataSortByColumnsMultiple(&$data = [], $col = "qty", $dir = SORT_DESC, $colTwo = "qty", $dirTwo = SORT_DESC)
    {
        $this->getDataSortByColumns($data, $col, $dir, $colTwo, $dirTwo);
    }

    // pre-sort things to make it easier on the admin
    public function getDataSortByColumns(&$data = [], ...$args)
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

        switch (!empty($params)) {

            case true:
                $params[] = &$data;
                call_user_func_array('array_multisort', $params);
                $data = array_pop($params);
                break;
        }
    }

    // returns some output (that is provided) and true for testing things
    // in templates (knowing that you received it, and that it is not just
    // displaying, or that it aint there baby) this works.
    public function testOutput($output = null): bool
    {
        try {
            print_r($output);
            return true;
        } catch (Throwable $e) {
            return false;
        }
    }

    // returns the value of a defined key from an array (very useful)
    protected function _getArrayValue($arr = [], $k = 0, $default = null)
    {
        return $arr[$k] ?? $default;
    }

}
