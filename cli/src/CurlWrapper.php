<?php
namespace Exchanger;


/**
 * This class is used as a wrapper for curl requests against an endpoint
 *  @param string $endpoint
 *  @param array $config
 *  @return array|string
 */
class CurlWrapper
{
    // private $baseUrl;
    private $username;
    private $password;
    private $endpoint;

    public function __construct($endpoint, $config=array("username" => null, "password" => null)) 
    {
        $this->endpoint = $endpoint;
        $this->username = $config["username"];
        $this->password = $config["password"]; 
    }

    public function call($method, $data = false)
    {
        $url = $this->endpoint;
        echo $url . "\n";
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case "PUT":
                // CURLOPT_PUT is deprecated and should not be used
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            default:
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }

        // Optional Authentication:
        if ($this->username && $this->password) {
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, "$this->username:$this->password");
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 8);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new \Exception('cURL error: ' . curl_error($curl));
        }

        curl_close($curl);

        return $response;
    }
}

