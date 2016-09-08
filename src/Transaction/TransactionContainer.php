<?php

namespace SwedbankPaymentPortal\Transaction;

use SwedbankPaymentPortal\CallbackInterface;

/**
 * Container for transaction frames.
 */
class TransactionContainer
{
    /**
     * @var TransactionFrame[]
     */
    private $frames = [];

    /**
     * @var string Key of the transaction container (merchant transaction id).
     */
    private $key;

    /**
     * @var CallbackInterface
     */
    private $callback;

    /**
     * @var bool
     */
    private $pendingResult = false;

    /**
     * @var \DateTime
     */
    private $enteredToSuccessUrlTime;

    /**
     * @var \DateTime
     */
    private $lastQueryingTime;


    /**
     * TransactionContainer constructor.
     *
     * @param string            $key
     * @param CallbackInterface $callback
     * @param bool              $pendingResult
     * @param \DateTime         $enteredToSuccessUrlTime
     * @param \DateTime         $lastQueryingTime
     */
    public function __construct($key, CallbackInterface $callback, $pendingResult = true, \DateTime $enteredToSuccessUrlTime = null, \DateTime $lastQueryingTime = null)
    {
        $this->key = $key;
        $this->callback = $callback;
        $this->enteredToSuccessUrlTime = $enteredToSuccessUrlTime;
        $this->pendingResult = $pendingResult;
        $this->lastQueryingTime = $lastQueryingTime ? $lastQueryingTime : new \DateTime();
    }

    /**
     * @return TransactionFrame|null
     */
    public function getFirstFrame()
    {
        $frames = $this->getFrames();
        return reset($frames);
    }

    /**
     * Frames getter.
     *
     * @return TransactionFrame[]
     */
    public function getFrames()
    {
        return $this->frames;
    }

    /**
     * Frames setter.
     *
     * @param TransactionFrame $frames
     */
    public function setFrames($frames)
    {
        $this->frames = $frames;
    }

    /**
     * Key getter.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Key setter.
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Adds a transaction frame.
     *
     * @param TransactionFrame $frame
     */
    public function addFrame(TransactionFrame $frame)
    {
        $this->frames[] = $frame;
    }

    /**
     * Callback getter.
     *
     * @return CallbackInterface
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * PendingResult getter.
     *
     * @return bool
     */
    public function isPendingResult()
    {
        return $this->pendingResult;
    }

    /**
     * PendingResult setter.
     *
     * @param bool $pendingResult
     */
    public function setPendingResult($pendingResult)
    {
        $this->pendingResult = $pendingResult;
    }

    /**
     * @return \DateTime
     */
    public function getEnteredToSuccessUrlTime()
    {
        return $this->enteredToSuccessUrlTime;
    }

    /**
     * @param \DateTime $enteredToSuccessUrlTime
     */
    public function setEnteredToSuccessUrlTime(\DateTime $enteredToSuccessUrlTime)
    {
        $this->enteredToSuccessUrlTime = $enteredToSuccessUrlTime;
    }

    /**
     * @return \DateTime
     */
    public function getLastQueryingTime()
    {
        return $this->lastQueryingTime;
    }

    /**
     * @param \DateTime $lastQueryingTime
     */
    public function setLastQueryingTime(\DateTime $lastQueryingTime)
    {
        $this->lastQueryingTime = $lastQueryingTime;
    }
}
