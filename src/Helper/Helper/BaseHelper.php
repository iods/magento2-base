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

class BaseHelper extends AbstractHelper
{
    protected ObjectManagerInterface $_objectManager;

    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager
    ) {
        parent::__construct($context, $objectManager);
    }

    /*
     * We build the base helper with some smaller helpers to
     * limit the overage of all the code shits
     * then the base one can be extended if it uses two or
     * more of the helpers.
     */

    public function testOutput($output = null): bool
    {
        try {
            return parent::testOutput($output);
        } catch (Throwable $e) {
            $this
        }
    }
}
