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

use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;
use Throwable;

/**
 * Class BaseHelper
 * @package Iods\Base\Helper
 */
class BaseHelper extends AbstractHelper
{
    /** @var File */
    protected File $_file_helper;

    /** @var Log */
    protected Log $_log;

    /** @var ObjectManagerInterface */
    protected ObjectManagerInterface $_object_manager;

    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager
    ) {
        parent::__construct($context, $objectManager);
        $this->_file_helper = $this->buildClassObject(File::class);
        $this->_log = $this->buildClassObject(Log::class);
    }

    /*
     * We build the base helper with some smaller helpers to
     * limit the overage of all the code shits
     * then the base one can be extended if it uses two or
     * more of the helpers.
     */

    public function getFileHelper(): File|null
    {
        return $this->_file_helper;
    }

    public function getBlockHtml($block_id = null): mixed
    {
        try {
            $block = $this->buildClassObject('Magento\Cms\Block\Block');
            $block->setBlockId($block_id);
            $html = $block->toHtml();
        } catch (Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
            $html = null;
        } finally {
            return $html;
        }
    }

    public function buildClassObject($class_name = null): mixed
    {
        try {
            $object = parent::buildClassObject($class_name);
        } catch (Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
            $object = null;
        } finally {
            return $object;
        }
    }

    public function displayBlock($id = null)
    {
        try {
            $this->testOutput($this->getBlockHtml($id));
        } catch (Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
        }
    }

    /**
     * Wrap the output in a custom log, returning false by default.
     * @param $output
     * @return bool
     */
    public function testOutput($output = null): bool
    {
        try {
            return parent::testOutput($output);
        } catch (Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
            return false;
        }
    }
}
