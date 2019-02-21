<?php

namespace RobsonVLeite\CafeApi;

/**
 * Class CafeApi
 * @package RobsonVLeite\CafeApi
 */
abstract class CafeApi
{
    /** @var string */
    private $apiUrl;

    /** @var array */
    private $headers;

    /** @var array */
    private $fields;

    /** @var string */
    private $endpoint;

    /** @var string */
    private $method;

    /** @var object */
    protected $response;

    /**
     * CafeApi constructor.
     * @param string $apiUrl
     * @param string $email
     * @param string $password
     */
    public function __construct(string $apiUrl, string $email, string $password)
    {
        $this->apiUrl = $apiUrl;
        $this->headers([
            "email" => $email,
            "password" => $password
        ]);
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array|null $fields
     * @param array|null $headers
     */
    protected function request(string $method, string $endpoint, array $fields = null, array $headers = null): void
    {
        $this->method = $method;
        $this->endpoint = $endpoint;
        $this->fields = $fields;
        $this->headers($headers);

        $this->dispatch();
    }

    /**
     * @return object|null
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * @return object|null
     */
    public function error()
    {
        if (!empty($this->response->errors)) {
            return $this->response->errors;
        }

        return null;
    }

    /**
     * @param array|null $headers
     */
    private function headers(?array $headers): void
    {
        if (!$headers) {
            return;
        }

        foreach ($headers as $key => $header) {
            $this->headers[] = "{$key}: {$header}";
        }
    }

    /**
     *
     */
    private function dispatch(): void
    {
        $curl = curl_init();

        if (empty($this->fields["files"])) {
            $this->fields = (!empty($this->fields) ? http_build_query($this->fields) : null);
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => "{$this->apiUrl}/{$this->endpoint}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $this->method,
            CURLOPT_POSTFIELDS => $this->fields,
            CURLOPT_HTTPHEADER => $this->headers,
        ));

        $this->response = json_decode(curl_exec($curl));
        curl_close($curl);
    }
}