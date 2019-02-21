<?php

namespace RobsonVLeite\CafeApi;

/**
 * Class Wallets
 * @package RobsonVLeite\CafeApi
 */
class Wallets extends CafeApi
{
    /**
     * Wallets constructor.
     * @param string $apiUrl
     * @param string $email
     * @param string $password
     */
    public function __construct(string $apiUrl, string $email, string $password)
    {
        parent::__construct($apiUrl, $email, $password);
    }

    /**
     * @param array|null $headers
     * @return Wallets
     */
    public function index(?array $headers): Wallets
    {
        $this->request(
            "GET",
            "/wallets",
            null,
            $headers
        );

        return $this;
    }

    /**
     * @param array $fields
     * @return Wallets
     */
    public function create(array $fields): Wallets
    {
        $this->request(
            "POST",
            "/wallets",
            $fields
        );

        return $this;
    }

    /**
     * @param int $walletId
     * @return Wallets
     */
    public function read(int $walletId): Wallets
    {
        $this->request(
            "GET",
            "/wallets/{$walletId}"
        );

        return $this;
    }

    /**
     * @param int $walletId
     * @param array $fields
     * @return Wallets
     */
    public function update(int $walletId, array $fields): Wallets
    {
        $this->request(
            "PUT",
            "/wallets/{$walletId}",
            $fields
        );

        return $this;
    }

    /**
     * @param int $walletId
     * @return Wallets
     */
    public function delete(int $walletId): Wallets
    {
        $this->request(
            "DELETE",
            "/wallets/{$walletId}"
        );

        return $this;
    }
}