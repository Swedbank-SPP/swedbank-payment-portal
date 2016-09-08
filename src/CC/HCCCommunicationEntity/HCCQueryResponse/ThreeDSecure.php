<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse;

use JMS\Serializer\Annotation as Annotation;
use SwedbankPaymentPortal\CC\Type\CardholderRegisterStatus;

/**
 * The container for 3d secure data.
 *
 * @Annotation\AccessType("public_method")
 */
class ThreeDSecure
{
    /**
     * The value used by the Payment Gateway to calculate the 3-D Secure security code. Returned for reference only.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("CAVV")
     */
    private $cavv;

    /**
     * Trancsction ID..
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("XID")
     */
    private $xid;

    /**
     * Indicates whether the cardholder was registered for 3-D Secure and the PARes / VERes status.
     *
     * @var CardholderRegisterStatus
     *
     * @Annotation\Type("SwedbankPaymentPortal\CC\Type\CardholderRegisterStatus")
     * @Annotation\SerializedName("cardholder_registered")
     */
    private $cardholderRegistered;

    /**
     * The Electronic Commerce Indicator (ECI).
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $eci;

    /**
     * ThreeDSecure constructor.
     *
     * @param string                   $cavv
     * @param string                   $xid
     * @param CardholderRegisterStatus $cardholderRegistered
     * @param string                   $eci
     */
    public function __construct($cavv, $xid, CardholderRegisterStatus $cardholderRegistered, $eci)
    {
        $this->cavv = $cavv;
        $this->xid = $xid;
        $this->cardholderRegistered = $cardholderRegistered;
        $this->eci = $eci;
    }

    /**
     * Cavv getter.
     *
     * @return string
     */
    public function getCavv()
    {
        return $this->cavv;
    }

    /**
     * Cavv setter.
     *
     * @param string $cavv
     */
    public function setCavv($cavv)
    {
        $this->cavv = $cavv;
    }

    /**
     * Xid getter.
     *
     * @return string
     */
    public function getXid()
    {
        return $this->xid;
    }

    /**
     * Xid setter.
     *
     * @param string $xid
     */
    public function setXid($xid)
    {
        $this->xid = $xid;
    }

    /**
     * CardholderRegistered getter.
     *
     * @return CardholderRegisterStatus
     */
    public function getCardholderRegistered()
    {
        return $this->cardholderRegistered;
    }

    /**
     * CardholderRegistered setter.
     *
     * @param CardholderRegisterStatus $cardholderRegistered
     */
    public function setCardholderRegistered($cardholderRegistered)
    {
        $this->cardholderRegistered = $cardholderRegistered;
    }

    /**
     * Eci getter.
     *
     * @return string
     */
    public function getEci()
    {
        return $this->eci;
    }

    /**
     * Eci setter.
     *
     * @param string $eci
     */
    public function setEci($eci)
    {
        $this->eci = $eci;
    }
}
