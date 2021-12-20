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

namespace Iods\Core\Test\Unit\Model\Config;

use Iods\Core\Model\Config\Version;
use Magento\Framework\Exception\LocalizedException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Safe\Exceptions\JsonException;

class VersionTest extends TestCase
{
    protected $_abstractResource;

    protected $_abstractDb;

    protected $_context;

    protected array $_data = [];

    protected $_manager;

    protected $_moduleList;

    protected $_registry;

    protected $_resource;

    protected $_scopeConfig;

    protected $_typeList;

    protected $_testObject;

    protected $_testReflection;


    protected function setUp(): void
    {
        $this->_testObject = new Version(
            $this->_getMockDependency('_abstractResource', 'Magento\Framework\Model\ResourceModel\AbstractResource'),
            $this->_getMockDependency('_abstractDb', 'Magento\Framework\Data\Collection\AbstractDb'),
            $this->_getMockDependency('_context', 'Magento\Framework\Model\Context'),
            $this->_getMockDependency('_manager', 'Magento\Framework\Module\Manager'),
            $this->_getMockDependency('_moduleList', 'Magento\Framework\Module\ModuleList'),
            $this->_getMockDependency('_registry', 'Magento\Framework\Registry'),
            $this->_getMockDependency('_resource', 'Magento\Framework\Module\ResourceInterface'),
            $this->_getMockDependency('_scopeConfig', 'Magento\Framework\App\Config\ScopeConfigInterface'),
            $this->_getMockDependency('_typeList', 'Magento\Framework\App\Cache\TypeListInterface'),
            $this->_data
        );
        $this->_testReflection = new \ReflectionClass(Version::class);
    }


    protected function _getMockDependency($property, $class)
    {
        if (empty($this->{$property})) {
            $this->{$property} = $this->getMockBuilder($class)
                ->disableOriginalConstructor()
                ->getMock();
        }

        return $this->{$property};
    }


    /**
     * @throws LocalizedException
     * @throws JsonException
     */
    public function testAfterLoad()
    {
        // $this->doesNotPerformAssertions();
        $this->_moduleList->method('getNames')
            ->willReturn([]);
        $this->_testObject->afterLoad();
    }

    /**
     * @throws JsonException
     */
    public function testAfterLoadLocalizedException()
    {
        $this->expectException(LocalizedException::class);
        $this->expectErrorMessage('Could not retrieve the module list.');
        $this->_testObject->afterLoad();
    }

    public function testAfterLoadJsonException()
    {
        $this->expectException(JsonException::class);
    }


    /**
     * @throws ReflectionException
     */
    public function testGetCustomValues($list, $status, $expected)
    {
        $method = $this->_testReflection->getMethod('getCustomModules');
        $method->setAccessible(true);

        $this->_moduleList->method('getNames')
            ->willReturn($list);

        $this->_moduleList->method('getDbVersion')
            ->willReturn($this->returnCallback([$this, 'getVersionCallback']));

        $this->_moduleList->method('isEnabled')
            ->willReturn($status);

        $result = $method->invoke($this->_testObject);
        $this->assertEquals($result, $expected);
    }


    public function dataProvider(): array
    {
        return [
            'Empty List' => [ // test case description
                [], 1, '[]' // params: list, status, expected_result
            ],
            'Module List w/ No Match' => [
                ['Test_Customer', 'Test_Cms'], 1, '[]'
            ],
            'Module List w/ Enabled Match' => [
                ['Test_Customer', 'Test_Cms', 'Iods_Core'],
                1,
                '[{"name":"Iods_Core","version":"1.0.0","active":1}]'
            ],
            'Module List w/ Disabled Match' => [
                ['Test_Customer', 'Test_Cms', 'Iods_Core'],
                0,
                '[{"name":"Iods_Core","version":"1.0.0","active":0}]'
            ],
            'Module List w/ Multiple Matches' => [
                ['Test_Customer', 'Test_Cms', 'Iods_Core', 'Iods_Developer'],
                1,
                '[{"name":"Iods_Core","version":"1.2.0","active":1},{"name":"Iods_Developer","version":"1.2.0","active":1}]'
            ],
        ];
    }


    public function getVersionCallback(): string
    {
        $args = func_get_args();
        $ver = '1.0.1';
        if (!is_string($args[0])) {
            $ver .= '.1';
        }

        return $ver;
    }
}