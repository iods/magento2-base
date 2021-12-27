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

namespace Iods\Core\Model;

final class Environment
{
    const DEVELOPMENT = 'development';
    const LOCAL       = 'local';
    const PRODUCTION  = 'production';
    const STAGING     = 'staging';

    public static function isValid($environment): bool
    {
        return $environment === self::DEVELOPMENT || $environment === self::LOCAL || $environment === self::PRODUCTION || $environment === self::STAGING;
    }

    public static function all(): array
    {
        return [
            self::DEVELOPMENT,
            self::LOCAL,
            self::PRODUCTION,
            self::STAGING,
        ];
    }

    private function __construct() {}
}