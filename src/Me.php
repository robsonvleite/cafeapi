<?php

namespace RobsonVLeite\CafeApi;

/**
 * Class Me
 * @package RobsonVLeite\CafeApi
 */
class Me extends CafeApi
{
    /**
     * Me constructor
     * @param string $apiUrl
     * @param string $email
     * @param string $password
     */
    public function __construct(string $apiUrl, string $email, string $password)
    {
        parent::__construct($apiUrl, $email, $password);
    }

    /**
     * @return Me
     */
    public function me(): Me
    {
        $this->request(
            "GET",
            "/me"
        );

        return $this;
    }

    /**
     * @param array $fields
     * @return Me
     */
    public function update(array $fields): Me
    {
        $this->request(
            "PUT",
            "/me",
            $fields
        );

        return $this;
    }

    /**
     * @param array $files
     * @return Me
     */
    public function photo(array $files): Me
    {
        $this->request(
            "POST",
            "/me/photo",
            [
                "files" => true,
                "photo" => curl_file_create($files["tmp_name"], $files["type"])
            ]
        );

        return $this;
    }
}