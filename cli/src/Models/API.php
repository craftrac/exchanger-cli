<?php
namespace Exchanger\Models;
use Exchanger\Config; 

/**
 * API model class
 * This class is used to call an API 
 * Create a child class in order to use another API
 */
abstract class API {
    protected $baseUrl;
    protected $apiKey;

    public function __construct($api) {
        $this->apiKey = Config::getApiKey($api);
        $this->baseUrl = Config::getApiBaseUrl($api);
        $this->setApiKey($this->apiKey);
    }

    private function setApiKey($key) {
        $this->apiKey = $key;
    }
    
    private function getApiKey() {
        return $this->apiKey;
    }

}

