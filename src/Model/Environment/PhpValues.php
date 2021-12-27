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

namespace Iods\Core\Model\Environment;

use Exception;
use Iods\Core\Api\Environment\ConfigValuesProvider;

class PhpValues implements ConfigValuesProvider
{
    private string $_filePath;

    public function __construct(string $filePath)
    {
        $this->_filePath = $filePath;
    }

    public function getValues(): ConfigValues
    {
        if (!is_file($this->_filePath) || !is_readable($this->_filePath)) {
            throw new Exception(sprintf(
                'Could not access the file at %s',
                $this->_filePath
            ));
        }
        $values = include $this->_filePath;
        if (!$values instanceof ConfigValues) {
            throw new Exception(sprintf(
                'The file at %s was not eval\'d to an instance of %s',
                $this->_filePath,
                ConfigValues::class
            ));
        }
        return $values;
    }
}