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

namespace Iods\Core\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Page\Config;

class AddBodyClass implements ObserverInterface
{
    protected Config $_config;

    protected $_customerSession;

    public function __construct(
        Config $config,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->_config = $config;
        $this->_customerSession = $customerSession;
    }

    public function execute(Observer $observer)
    {
        $isLoggedIn = $this->_customerSession->isLoggedIn();
        if ($isLoggedIn) {
            $this->_config->addBodyClass('logged-in');
        }
    }
}