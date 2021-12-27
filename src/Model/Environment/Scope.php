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

use Iods\Core\Api\Environment\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Scope implements ScopeInterface
{
    private int $_scopeCode;

    private string $_scopeType;

    public function __construct(
        int $scopeCode = 0,
        string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT
    ) {
        $this->_scopeCode = $scopeCode;
        $this->_scopeType = $scopeType;
    }

    public function getScopeCode(): int
    {
        return$this->_scopeCode;
    }

    public function getScopeType(): string
    {
        return $this->_scopeType;
    }
}