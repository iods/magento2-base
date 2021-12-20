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

namespace Iods\Core\Model\Config\Source\Product;

use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Attribute implements OptionSourceInterface
{
    protected $_collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->_collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        $data = [];
        $attr = $this->_collectionFactory->create();
        $data[] = [
            'label' => __('Select from Product Attributes.'),
            'value' => '0'
        ];
        foreach ($attr as $item) {
            $data[] = [
                'label' => $item->getData('frontend_label'),
                'value' => $item->getData('attribute_code')
            ];
        }
        return $data;
    }
}