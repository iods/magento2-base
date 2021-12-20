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

use Magento\Config\Block\System\Config\Form\Field;

class Version extends Field
{
    // template path
    protected string $_template = 'Iods_Core::system/config/module_version.phtml';

    // config for iods
    protected $_config;


}