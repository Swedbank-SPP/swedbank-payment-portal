<?php

namespace SwedbankPaymentPortal\Transaction;

use SwedbankPaymentPortal\Serializer;

/**
 * Transaction frame.
 */
class TransactionFrame
{
    /**
     * Request object.
     *
     * @var object
     */
    private $request;

    /**
     * Response object.
     *
     * @var object
     */
    private $response;
    
    /**
     * TransactionFrame constructor.
     *
     * @param object $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Request getter.
     *
     * @return object
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Request setter.
     *
     * @param object $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * Response getter.
     *
     * @return object|mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Response setter.
     *
     * @param object $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }
}
