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

namespace Iods\Core\Block\Adminhtml\System\Config\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Information extends Field
{
    protected string $_template = 'Iods_Core::system/config/field/information.phtml';

    public function __construct(
        Context $context,
        array   $data = []
    ) {
        parent::__construct(
            $context,
            $data
        );
    }

    public function render(AbstractElement $element): string
    {
        return $this->toHtml();
    }
}
