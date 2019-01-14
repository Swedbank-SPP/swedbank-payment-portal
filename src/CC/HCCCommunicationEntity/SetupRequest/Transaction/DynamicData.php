<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest\Transaction;

use Jms\Serializer\Annotation;

/**
 * The container for the Dynamic Data that is used to display information on the hosted page.
 */
class DynamicData
{
    /**
     * Field is optional and is used to control the display of the cardholder name field.
     *
     * Populate with “show” otherwise Cardholder Name will not be visible on capture page.
     * If value of show is supplied, cardholder name field will be displayed on hosted page.
     * Any other value or omission of this field will not display the cardholder name field.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("dyn_data_3")
     */
    private $cardHolderNameControl;

    /**
     * Fully qualified URL for the Go Back link that is displayed on the capture page.
     * A secure (https) URL must be provided. If left blank, the function will not work.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("dyn_data_4")
     */
    private $goBackLink;

    /**
     * Value supplied in this field should contain “Merchant Name” as it will be displayed on the hosted page.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("dyn_data_2")
     */
    private $merchanName;
    
    /**
     * Fully qualified URL for the logo to be displayed at the top left of the capture page. 
     * Please note image should be hosted from a secure location within your own system (https).
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("dyn_data_9")
     */
    private $logoUrl;
    
    /**
     * DynamicData constructor.
     *
     * @param string $cardHolderNameControl
     * @param string $goBackLink
     * @param string $merchantName
     * @param string $logoUrl
     */
    public function __construct($cardHolderNameControl = null, $goBackLink = null, $merchanName = null, $logoUrl = null)
    {
        $this->cardHolderNameControl = $cardHolderNameControl;
        $this->goBackLink = $goBackLink;
        $this->merchanName = $merchanName;
        $this->logoUrl = $logoUrl;
    }

    /**
     * CardHolderNameControl getter.
     *
     * @return string
     */
    public function getCardHolderNameControl()
    {
        return $this->cardHolderNameControl;
    }

    /**
     * CardHolderNameControl setter.
     *
     * @param string $cardHolderNameControl
     */
    public function setCardHolderNameControl($cardHolderNameControl)
    {
        $this->cardHolderNameControl = $cardHolderNameControl;
    }

    /**
     * GoBackLink getter.
     *
     * @return string
     */
    public function getGoBackLink()
    {
        return $this->goBackLink;
    }

    /**
     * GoBackLink setter.
     *
     * @param string $goBackLink
     */
    public function setGoBackLink($goBackLink)
    {
        $this->goBackLink = $goBackLink;
    }

    /**
     * MerchantName getter.
     *
     * @return string
     */
    public function getMerchantName()
    {
        return $this->merchanName;
    }

    /**
     * MerchantName setter.
     *
     * @param string $goBackLink
     */
    public function setMerchantName($merchantName)
    {
        $this->merchanName = $merchantName;
    }
    
    /**
     * Logo getter.
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logoUrl;
    }

    /**
     * Logo setter.
     *
     * @param string $goBackLink
     */
    public function setLogo($logoUrl)
    {
        $this->logoUrl = $logoUrl;
    }
}
