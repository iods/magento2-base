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

namespace Iods\Core\Tests\Unit\Console\Command;

use Iods\Core\Console\Command\RunSampleCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class RunSampleCommandTest extends TestCase
{
    private CommandTester $_commandTester;

    protected function _setUp(): void
    {
        $this->_commandTester = new CommandTester(
            new RunSampleCommand()
        );
    }

    public function testExecute(): void
    {
        $this->assertEquals(0, $this->_commandTester->execute([]));
        $this->assertEquals(
            'Sample command without interactions for testing.' . PHP_EOL,
            $this->_commandTester->getDisplay()
        );
    }
}