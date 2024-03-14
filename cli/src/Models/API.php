<?php
namespace Exchanger\Models;
use Exchanger\Config; 

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
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

