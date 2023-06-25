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

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;

/**
 * @TODO Build into a full cURL class.
 */
class Http extends AbstractHelper
{
    protected Curl $_curl;

    protected Log $_log;

    protected ObjectManagerInterface $_objectManager;

    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        Curl $curl,
        Log $log
    ) {
        parent::__construct($context, $objectManager);
        $this->_curl = $curl;
        $this->_log = $log;
    }


    /**
     * Returns the contents of a remote URL using a cURL request.
     * @param $url
     * @return string
     */
    public function getDataRemote($url = null): string
    {
        return $this->_get($url)->getBody();
    }


    public function callWebhook($hook_url = null, $message = null, $content_type = 'text/plain'): string
    {
        return $this->sendDataRemote($hook_url, $message, $content_type)->getBody();
    }

    public function callWebhookSlack($hook_url = null, $message = null): string
    {
        return $this->callWebhook($hook_url, json_encode(["text" => $message]), 'application/json');
    }


    public function isExistsUrl($url = null): bool
    {
        try {
            if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
                $host = isset($_SERVER["HTTP_HOST"]) ? stripslashes($_SERVER["HTTP_HOST"]) : 'ryemiller.com';
                $remote = "https://$host$url";
            }
            $exists = $this->_get($remote)->getStatus() === 200;
        } catch (\Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
            $exists = false;
        } finally {
            return $exists;
        }
    }


    /**
     * Send content to a remote URL using a cURL request.
     * @param $url
     * @param $data
     * @param $content_type
     * @return Curl
     */
    public function sendDataRemote($url = null, $data = null, $content_type = null): Curl
    {
        return $this->_post($url, $data, $content_type);
    }





    private function _get($url = null): Curl
    {
        try {
            $opts = [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7) Gecko/20040803 Firefox/0.9.3',
                CURLOPT_TIMEOUT => 45,
                CURLOPT_CONNECTTIMEOUT => 45,
            ];
            $this->_curl->setOptions($opts);
            $this->_curl->get($url);
        } catch (\Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
        } finally {
            return $this->_curl;
        }
    }


    private function _post($url = null, $data = null, $content_type = 'application/json'): Curl
    {
        try {
            $opts = [
                CURLOPT_TIMEOUT => 45,
                CURLOPT_CONNECTTIMEOUT => 45,
            ];
            $headers = [
                'Content-Type' => $content_type
            ];
            $this->_curl->setOptions($opts);
            $this->_curl->setHeaders($headers);
            $this->_curl->post($url, $data);
        } catch (\Throwable $e) {
            $this->_log->logError(__METHOD__, $e->getMessage());
        } finally {
            return $this->_curl;
        }
    }
}
