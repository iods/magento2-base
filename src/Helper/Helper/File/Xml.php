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

namespace Iods\Base\Helper\File;

use DOMDocument;
use Iods\Base\Helper\AbstractHelper;

class Xml extends AbstractHelper
{
    // ...

    /**
     * Returns the DOM Document pretty formatted when called before saving and XML file.
     * @param DOMDocument $input
     * @return DOMDocument
     */
    public function prettify(DOMDocument $input): DOMDocument
    {
        $pretty = new DOMDocument();
        $pretty->preserveWhiteSpace = false;
        $pretty->formatOutput = true;
        $pretty->loadXML($input->saveXML());

        return $pretty;
    }
}
