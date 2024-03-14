<?php
namespace Exchanger;

class Config {
   /**
    * path to the sqlite file
    */
    public static $API_URL;
    public static $API_KEY;
    public static $PGSQL_PASSWORD;
    public static $PGSQL_HOST;
    public static $PGSQL_USER;
    public static $PGSQL_DB;

    public static function load() {
        self::$API_URL = getenv('API_BASE_PATH');
        self::$API_KEY = getenv('API_KEY');
        self::$PGSQL_PASSWORD = getenv('DB_PASS');
        self::$PGSQL_HOST = getenv('DB_HOST');
        self::$PGSQL_USER = getenv('DB_USER');
        self::$PGSQL_DB = getenv('DB_NAME');
    }

    // Gets api base url for a specific API. You may add more in the future
    public static function getApiBaseUrl($api) {
        switch ($api) {
            case 'openexchangerates':
                return self::$API_URL; 
            default:
                throw new \Exception('Unknown API: ' . $api);
        } 
    }

    // Gets api key for a specific API. You may add more in the future
    public static function getApiKey($api) {
        switch ($api) {
            case 'openexchangerates':
                return self::$API_KEY; 
            default:
                throw new \Exception('Unknown API: ' . $api);
        } 
    }
}
