<?php
namespace Exchanger\Services;
use Exchanger\Models\API;
use Exchanger\CurlWrapper;
use Exchanger\Config;
require_once(__DIR__ . '/../helpers.php');


class ExchangeAPI extends API {

    protected $apiKey;
    protected $baseUrl;

    public function __construct() {
        parent::__construct('openexchangerates');
    }

    /**
     *  this method is used to call an API endpoint
     *  @param string $url
     *  @param array $data
     *  @return array
     */
    private function apiGet($url, $data = false) {
        // append API key to URL
        $url = $this->baseUrl . $url; 
        $url .= "?app_id={$this->apiKey}";
        $req = new CurlWrapper($url);
        $res = $req->call("GET");

        if (!is_json($res)) {
            throw new \Exception($res);
        } 

        $res = json_decode($res, true);

        // handle error
        if (array_key_exists('error', $res)) {
            var_dump($res['error']);
            throw new \Exception($res['description']);
        }

        return $res['rates'];
    }
    
    /**
     * Used to get historical exchange rates
     * @param string $date
     * @return array of arrays
     */
    public function getRatesHistory($params) {
        $dateFrom = $params['date_from'];
        $dateTo = $params['date_to'];
        $dates = array();
        $res = array();

        // generate the date array
        $dates = dates_from_range($dateFrom, $dateTo);

        // Iterate over date array
        forEach ($dates as $date) {
            $url = "historical/{$date}.json";
            $res[$date] = $this->apiGet($url);
        }
        
        return $res;
    }

    // Prepare the data array to insert into database
    public function prepare($data) {
        $rows = array();
        foreach ($data as $date => $rates) {
            foreach ($rates as $currency => $rate) {
                // Prepare the data array for each currency rate
                $rows[] = [
                    ':date' => $date, 
                    ':symbol' => $currency,
                    ':rate' => $rate,
                ];
            }
        }
        return $rows;
    }

}
