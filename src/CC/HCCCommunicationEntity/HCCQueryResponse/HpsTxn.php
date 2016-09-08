<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse;

use JMS\Serializer\Annotation as Annotation;

/**
 *
 * @Annotation\XmlRoot("Response")
 * @Annotation\AccessType("public_method")
 */
class HpsTxn
{
    /**
     * Capture status
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("capture_status")
     */
    private $captureStatus;

    /**
     * The Card scheme of the card provided by the cardholder during the capture process.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("card_scheme")
     */
    private $cardScheme;

    /**
     * Is CV2 captured
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("cv2_captured")
     */
    private $cv2Captured;

    /**
     * Card expiry date.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("expirydate")
     */
    private $expiryDate;

    /**
     * Who issued the card.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $issuer;

    /**
     * The masked card number captured from the hosted page .
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $pan;

    /**
     * HpsTxn constructor.
     *
     * @param string $captureStatus
     * @param string $cardScheme
     * @param string $cv2Captured
     * @param string $expiryDate
     * @param string $issuer
     * @param string $pan
     */
    public function __construct($captureStatus, $cardScheme, $cv2Captured, $expiryDate, $issuer, $pan)
    {
        $this->captureStatus = $captureStatus;
        $this->cardScheme    = $cardScheme;
        $this->cv2Captured   = $cv2Captured;
        $this->expiryDate    = $expiryDate;
        $this->issuer        = $issuer;
        $this->pan           = $pan;
    }

    /**
     * @return string
     */
    public function getCaptureStatus()
    {
        return $this->captureStatus;
    }

    /**
     * @param string $captureStatus
     */
    public function setCaptureStatus($captureStatus)
    {
        $this->captureStatus = $captureStatus;
    }

    /**
     * @return string
     */
    public function getCardScheme()
    {
        return $this->cardScheme;
    }

    /**
     * @param string $cardScheme
     */
    public function setCardScheme($cardScheme)
    {
        $this->cardScheme = $cardScheme;
    }

    /**
     * @return string
     */
    public function getCv2Captured()
    {
        return $this->cv2Captured;
    }

    /**
     * @param string $cv2Captured
     */
    public function setCv2Captured($cv2Captured)
    {
        $this->cv2Captured = $cv2Captured;
    }

    /**
     * @return string
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * @param string $expiryDate
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;
    }

    /**
     * @return string
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param string $issuer
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
    }

    /**
     * @return string
     */
    public function getPan()
    {
        return $this->pan;
    }

    /**
     * @param string $pan
     */
    public function setPan($pan)
    {
        $this->pan = $pan;
    }

}
