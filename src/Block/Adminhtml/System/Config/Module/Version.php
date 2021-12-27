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

use Iods\Core\Model\Config;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Version extends Field
{
    // template path
    protected string $_template = 'Iods_Core::system/config/module_version.phtml';

    // config for iods
    protected Config $_config;

    public function __construct(
        Context $context,
        Config $config,
        array $data = []
    ) {
        $this->_config = $config;
        parent::__construct(
            $context,
            $data
        );
    }

    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    public function getModuleVersion(): string
    {
        return $this->_config->getModuleVersion();
    }

    protected function _getElementHtml(AbstractElement $element): string
    {
        return $this->_toHtml();
    }
}