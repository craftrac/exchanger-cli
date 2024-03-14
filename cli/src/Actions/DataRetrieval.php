<?php
namespace Exchanger\Actions;
use Exchanger\Models\Action;
use Exchanger\Services\ExchangeAPI;

class DataRetrieval implements Action
{
    private $source;
    private $method;
    private $params;
    public $data;

    public function __construct($source, $method, $params = array()) {
        if ($source === 'openexchange') {
            $this->source = new ExchangeAPI(); 
            $this->method = $method;
            $this->params = $params;
        } else {
            throw new \Exception('Source not found');
        }   
    }

    // Retrieves data from remote API  
    public function execute() {
        $method = $this->method;
        $this->data = $this->source->$method($this->params);
    }

    public function prepare() {
        $this->data = $this->source->prepare($this->data);
    }
}

