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

namespace Iods\Base\Helper\Text;

use Iods\Base\Helper\AbstractHelper;

class Str extends AbstractHelper
{
    private static array $_camel_store = [];

    private static array $_studly_store = [];

    public static function snake($text)
    {
        if (isset(self::$_camel_store[$text])) {
            return self::$_camel_store[$text];
        }

        if (!ctype_lower($text)) {
            $k = $text;
            $text = preg_replace('/\s+/u', '', ucwords($text));
            $text_new = preg_replace('/(.)(?=[A-Z])/u', '$1' . '_', $text);
            $text = mb_strtolower($text_new, 'UTF-8');
            self::$_camel_store[$k] = $text;
        }

        return $text;
    }


    public static function studly($value)
    {
        if (isset(static::$_studly_store[$value])) {
            return static::$_studly_store[$value];
        }

        $text = ucwords(preg_replace('/[^a-zA-A0-9]+/', '', $value));

        return static::$_studly_store[$value] = str_replace(' ', '', $text);
    }
}
