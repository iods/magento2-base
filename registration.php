<?php
/**
 * Core module and extension testing for Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright © 2020, Rye Miller (https://ryemiller.io)
 * @license   MIT License
 */
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Iods_Core',
    __DIR__
);
