<?php
namespace Exchanger;
use PDO;
use Exchanger\Config;
include_once(__DIR__ . '/helpers.php');

/**
 * PGSql connnection
 */
class Postgres {
    /**
     * PDO instance
     */
    public static $error;
    private static $user; 
    private static $password;
    private static $host;
    private static $name;
    private static $pdo;

    /**
     * return in instance of the PDO object that connects to the Postgres database
     * @return bool
     *
     */
    public static function connect() {
        self::$user = Config::$PGSQL_USER; 
        self::$password = Config::$PGSQL_PASSWORD;
        self::$host = Config::$PGSQL_HOST;
        self::$name = Config::$PGSQL_DB;

        try {
            $host = self::$host;
            $user = self::$user;
            $password = self::$password;
            $name = self::$name;
            $dsn = "pgsql:host={$host};port=5432;dbname={$name};";
            // make a database connection
            $pdo = new \PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

            if ($pdo) {
                echo "Connected to the {$name} database successfully!";
                self::$pdo = $pdo;
                return true;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        } finally {
            if ($pdo) {
                $pdo = null;
            }
        }

        return false;
    }

    public static function insertRates($data) {
        try {
            $sql = "INSERT INTO rates (currency_date, currency_symbol, currency_rate) VALUES (:date, :symbol, :rate) ON CONFLICT (currency_date, currency_symbol)
                    DO UPDATE SET currency_rate = EXCLUDED.currency_rate;";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute($data);
        } catch (\PDOException $e) {
            // Handle error appropriately
            echo "Error inserting data: " . $e->getMessage() . "\n";
        }
    }

    public static function refreshMaterializedView($viewName) {
        try {
            $sql = "REFRESH MATERIALIZED VIEW {$viewName};";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute();
            echo "Materialized view refreshed successfully.\n";
        } catch (\PDOException $e) {
            // Handle error appropriately
            echo "Error refreshing materialized view: " . $e->getMessage() . "\n";
        }
    }

    public static function close() {
        self::$pdo = null;
    }
}
