<?php

namespace RobsonVLeite\CafeApi;

/**
 * Class Subscriptions
 * @package RobsonVLeite\CafeApi
 */
class Subscriptions extends CafeApi
{

    /**
     * Subscriptions constructor.
     * @param string $apiUrl
     * @param string $email
     * @param string $password
     */
    public function __construct(string $apiUrl, string $email, string $password)
    {
        parent::__construct($apiUrl, $email, $password);
    }

    /**
     * @return Subscriptions
     */
    public function index(): Subscriptions
    {
        $this->request(
            "GET",
            "/subscription"
        );

        return $this;
    }

    /**
     * @param array $fields
     * @return Subscriptions
     */
    public function create(array $fields): Subscriptions
    {
        $this->request(
            "POST",
            "/subscription",
            $fields
        );

        return $this;
    }

    /**
     * @return Subscriptions
     */
    public function read(): Subscriptions
    {
        $this->request(
            "GET",
            "/subscription/plans"
        );

        return $this;
    }

    /**
     * @param array $fields
     * @return Subscriptions
     */
    public function update(array $fields): Subscriptions
    {
        $this->request(
            "PUT",
            "/subscription",
            $fields
        );

        return $this;
    }
}