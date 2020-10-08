<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade the modules in the
 * Darkstar suite to newer versions in the future.
 *
 * @category  Iods
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2020, Rye Miller (http://ryemiller.io)
 * @license   MIT (https://en.wikipedia.org/wiki/MIT_License)
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Iods_Core',
    __DIR__
);
