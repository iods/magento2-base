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

// what are we putting in AbstractData that needs to be used?

// why abstracthelper then abstractdata? or both?

// basic module information
// store details?

use Exception;
use Magento\Backend\App\Config;
use Magento\Framework\App\Area;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\App\State;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class AbstractData extends AbstractHelper
{
    public const CONFIG_MODULE_PATH = 'iods';

    /**
     * @var Config
     */
    protected Config $_config;

    /**
     * @var array
     */
    protected array $_data = [];

    /**
     * @var array
     */
    protected array $_isArea = [];

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $_store_manager;

    /**
     * @param Context $context
     * @param ObjectManagerInterface $object_manager
     * @param StoreManagerInterface $store_manager
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $object_manager,
        StoreManagerInterface $store_manager
    ) {
        $this->_store_manager = $store_manager;

        parent::__construct($context, $object_manager);
    }

    /**
     * @param $path
     * @param array $args
     * @return mixed
     */
    public function createObject($path, array $args = []): mixed
    {
        return $this->_object_manager->create($path, $args);
    }

    /**
     * @return mixed
     */
    public function getDataCurrentUrl(): mixed
    {
        $url = $this->_object_manager->get(UrlInterface::class);
        return $url->getCurrentUrl();
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getData($name): mixed
    {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
        return null;
    }

    /**
     * @param string $code
     * @param $store_id
     * @return bool
     */
    public function getDataConfigGeneral(string $code = '', $store_id = null): bool
    {
        $code = ($code !== '') ? '/' . $code : '';
        return $this->getDataConfigValue(static::CONFIG_MODULE_PATH . '/general' . $code, $store_id);
    }

    /**
     * @param string $field
     * @param $store_id
     * @return array|mixed
     */
    public function getDataConfigModule(string $field = '', $store_id = null): mixed
    {
        $field = ($field !== '') ? '/' . $field : '';
        return $this->getDataConfigValue(static::CONFIG_MODULE_PATH . $field, $store_id);
    }

    /**
     * @TODO review the comparison issues
     *
     * @param $field
     * @param $scope_value
     * @param string $scope_type
     * @return array|mixed
     */
    public function getDataConfigValue($field, $scope_value = null, string $scope_type = ScopeInterface::SCOPE_STORE): mixed
    {
        if ($scope_value == null && !$this->isArea()) {
            return $this->_config->getValue($field);
        }
        return $this->scopeConfig->getValue($field, $scope_type, $scope_value);
    }

    /**
     * @return mixed
     */
    public function getEdition(): mixed
    {
        return $this->_object_manager->get(ProductMetadataInterface::class)->getEdition();
    }

    /**
     * @return Json|mixed
     */
    public static function getJsonHelper(): mixed
    {
        return ObjectManager::getInstance()->get(Json::class);
    }

    /**
     * @param $path
     * @return mixed
     */
    public function getObject($path): mixed
    {
        return $this->_object_manager->get($path);
    }

    /**
     * @return mixed
     */
    public function getSerializerClass(): mixed
    {
        return $this->_object_manager->get('Zend_Serializer_Adapter_PhpSerialize');
    }

    /**
     * Confirm it is Admin Store.
     * @return bool
     */
    public function isAdminhtml(): bool
    {
        return $this->isArea(Area::AREA_ADMINHTML);
    }

    /**
     * @param string $area
     * @return mixed
     */
    public function isArea(string $area = Area::AREA_FRONTEND): mixed
    {
        if (!isset($this->_isArea[$area])) {
            /** @var State $state */
            $state = $this->_object_manager->get(State::class);

            try {
                $this->_isArea[$area] = ($state->getAreaCode() == $area);
            } catch (Exception $e) {
                $this->_isArea[$area] = false;
            }
        }
        return $this->_isArea[$area];
    }

    /**
     * @param $store_id
     * @return bool
     */
    public function isEnabled($store_id = null): bool
    {
        return $this->getDataConfigGeneral('enabled', $store_id);
    }

    /**
     * Encode the mixed $data into the JSON format.
     * @param $data
     * @return string
     */
    public function jsonEncode($data): string
    {
        try {
            $encoded = self::getJsonHelper()->serialize($data);
        } catch (Exception $e) {
            $encoded = '{}';
        }
        return $encoded;
    }

    /**
     * Decodes the given $data string which is encoded in the JSON format.
     * @param $data
     * @return mixed
     */
    public function jsonDecode($data): mixed
    {
        try {
            $decoded = self::getJsonHelper()->unserialize($data);
        } catch (Exception $e) {
            $decoded = [];
        }
        return $decoded;
    }

    /**
     * @param $data
     * @return string
     */
    public function serialize($data): string
    {
        if ($this->versionCompare('2.3.6')) {
            return self::jsonEncode($data);
        }
        return $this->getSerializerClass()->serialize($data);
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function setData($name, $value): static
    {
        $this->_data[$name] = $value;
        return $this;
    }

    /**
     * @param $string
     * @return mixed
     */
    public function unserialize($string): mixed
    {
        if ($this->versionCompare('2.3.6')) {
            return self::jsonDecode($string);
        }
        return $this->getSerializerClass()->unserialize($string);
    }

    /**
     * @param $version
     * @param string $operator
     * @return int|bool
     */
    public function versionCompare($version, string $operator = '<='): int|bool
    {
        $productMetadata = $this->_object_manager->get(ProductMetadataInterface::class);
        $ver = $productMetadata->getVersion();

        return version_compare($ver, $version, $operator);
    }
}
