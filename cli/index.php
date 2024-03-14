#!/usr/bin/env php
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'vendor/autoload.php';
require_once 'src/helpers.php';
use Exchanger\Postgres;
use Exchanger\Actions\DataRetrieval;
use Exchanger\Config;

// Initialize database connection
Config::load();
Postgres::connect();

// default CLI command
$actionName = $argc > 1 && !is_date($argv[1]) ? $argv[1] : 'fetch-rates';
echo $argc;
// Action chooser. You may add more actions here
switch ($actionName) {
    case "fetch-rates":
        $arg1 = $argv[1] ?? current_date();
        $arg2 = $argv[2] ?? $arg1;

        if (!is_date($arg1) || !is_date($arg2)) {
            echo "Wrong arguments. Usage: php index.php fetch-rates <date_from> <date_to>\n";
            exit(1);
        }
        
        $params = array('date_from' => $arg1, 'date_to' => $arg2);
        $action = new DataRetrieval('openexchange', 'getRatesHistory', $params);
        $action->execute();
        $action->prepare();
        foreach ($action->data as $rate) {
            Postgres::insertRates($rate);
        }
        break;
    case 2:
        break;
    default:
        echo "Wrong action name: {$actionName}\n";
        exit(1);
}

// Terminate database connection
Postgres::close();

