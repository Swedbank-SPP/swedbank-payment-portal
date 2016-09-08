<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse;

use JMS\Serializer\Annotation as Annotation;

/**
 * The container for the XML request. Also contains the version attribute, which we recommend you set to 2.
 *
 * @Annotation\AccessType("public_method")
 */
class CardTxn
{
    /**
     * The container for the Address and card security code verification result.
     *
     * @var Cv2Avs
     *
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\Cv2Avs")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("Cv2Avs")
     */
    private $cv2Avs;

    /**
     * 3D secure data.
     *
     * @var ThreeDSecure
     *
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\ThreeDSecure")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("ThreeDSecure")
     */
    private $threeDSecure;

    /**
     * The authorization code returned from the acquirer.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("authcode")
     */
    private $authCode;

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
     * CardTxn constructor.
     *
     * @param Cv2Avs       $cv2Avs
     * @param ThreeDSecure $threeDSecure
     * @param string       $authCode
     * @param string       $cardScheme
     */
    public function __construct(Cv2Avs $cv2Avs, ThreeDSecure $threeDSecure, $authCode, $cardScheme)
    {
        $this->cv2Avs = $cv2Avs;
        $this->threeDSecure = $threeDSecure;
        $this->authCode = $authCode;
        $this->cardScheme = $cardScheme;
    }

    /**
     * Cv2Avs getter.
     *
     * @return Cv2Avs
     */
    public function getCv2Avs()
    {
        return $this->cv2Avs;
    }

    /**
     * Cv2Avs setter.
     *
     * @param Cv2Avs $cv2Avs
     */
    public function setCv2Avs($cv2Avs)
    {
        $this->cv2Avs = $cv2Avs;
    }

    /**
     * ThreeDSecure getter.
     *
     * @return ThreeDSecure
     */
    public function getThreeDSecure()
    {
        return $this->threeDSecure;
    }

    /**
     * ThreeDSecure setter.
     *
     * @param ThreeDSecure $threeDSecure
     */
    public function setThreeDSecure($threeDSecure)
    {
        $this->threeDSecure = $threeDSecure;
    }

    /**
     * AuthCode getter.
     *
     * @return string
     */
    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * AuthCode setter.
     *
     * @param string $authCode
     */
    public function setAuthCode($authCode)
    {
        $this->authCode = $authCode;
    }

    /**
     * CardScheme getter.
     *
     * @return string
     */
    public function getCardScheme()
    {
        return $this->cardScheme;
    }

    /**
     * CardScheme setter.
     *
     * @param string $cardScheme
     */
    public function setCardScheme($cardScheme)
    {
        $this->cardScheme = $cardScheme;
    }
}
