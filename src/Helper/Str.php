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

    public static function replaceSpecialChars($string): array|string
    {
        $rem = [
            'ă', 'Ă', 'ş', 'Ş', 'ţ', 'Ţ', 'à', 'á', 'â', 'ã',
            'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ð', 'ì',
            'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø',
            '§','ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'À', 'Á', 'Â',
            'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', '€',
            'Ð', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ',
            'Ö', 'Ø', '§', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Ÿ',
            '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;',
            '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;',
            '&ecirc;', '&euml;', '&eth;', '&igrave;', '&iacute;',
            '&icirc;', '&iuml;', '&ntilde;', '&ograve;', '&oacute;',
            '&ocirc;', '&otilde;', '&ouml;', '&oslash;', '&sect;',
            '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;',
            '&yuml;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;',
            '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;',
            '&Eacute;', '&Ecirc;', '&Euml;', '&euro;', '&ETH;', '&Igrave;',
            '&Iacute;', '&Icirc;', '&Iuml;', '&Ntilde;', '&Ograve;',
            '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&Oslash;', '&sect;',
            '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&Yuml;'
        ];

        $add = [
            'a', 'A', 's', 'S', 't', 'T', 'a', 'a', 'a', 'a',
            'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'ed', 'i',
            'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o',
            's', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'A', 'A',
            'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'EUR',
            'ED', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O',
            'O', 'O', 'S', 'U', 'U', 'U', 'U', 'Y', 'Y', 'a', 'a',
            'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'ed',
            'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 's',
            'u', 'u', 'u', 'u', 'y', 'y', 'A', 'A', 'A', 'A', 'A', 'A',
            'AE', 'C', 'E', 'E', 'E', 'E', 'EUR', 'ED', 'I', 'I', 'I',
            'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'S', 'U', 'U', 'U',
            'U', 'Y', 'Y'
        ];

        return str_replace($rem, $add, $string);
    }
}
