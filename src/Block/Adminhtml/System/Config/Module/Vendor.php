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

namespace Iods\Core\Block\Adminhtml\System\Config\Module;

use Iods\Core\Helper\Module;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Vendor extends Field
{
    private Module $_module;

    public function __construct(
        Context $context,
        Module $module,
        array $data = []
    ) {
        $this->_module = $module;
        parent::__construct(
            $context,
            $data
        );
    }

    public function render(AbstractElement $element): string
    {
        $element->unsetData();
        return parent::render($element);
    }

    protected function _getElementHtml(AbstractElement $element): string
    {
        return $this->_module->getModuleVersion();
    }
}