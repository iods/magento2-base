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

namespace Iods\Core\Plugin;

use Iods\Core\Helper\Data;

class MoveMenu
{
    const MENU_ID = 'Iods_Core::iods';

    protected Data $_helper;

    public function __construct(
        Data $helper
    ) {
        $this->_helper = $helper;
    }

    public function afterExecute($subject, &$params)
    {
        if ($this->_helper->getConfigValue('menu')) {
            if (strpos($params['id'], 'Iods_') !== false && isset($params['parent']) && strpos($params['parent'], 'Iods_') === false) {
                $params['parent'] = self::MENU_ID;
            }
        } elseif ((isset($params['id']) && $params['id'] === self::MENU_ID) || (isset($params['parent']) && $params['parent'] === self::MENU_ID)) {
            $params['removed'] = true;
        }
        return $params;
    }
}