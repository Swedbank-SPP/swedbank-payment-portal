<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction;

use Jms\Serializer\Annotation;
use SwedbankPaymentPortal\CC\Type\ScreeningAction;

/**
 * The container that contains the data to be risk screened.
 *
 * @Annotation\AccessType("public_method")
 */
class Action
{
    /**
     * This will indicate when if the transaction is to be screened pre or post authorisation.
     *
     * @var ScreeningAction
     *
     * @Annotation\Type("SwedbankPaymentPortal\CC\Type\ScreeningAction")
     * @Annotation\XmlAttribute
     */
    private $service;

    /**
     * The container for the merchant configuration.
     *
     * @var MerchantConfiguration
     *
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\MerchantConfiguration")
     * @Annotation\SerializedName("MerchantConfiguration")
     */
    private $merchantConfiguration;

    /**
     * Customer details.
     *
     * @var CustomerDetails
     *
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\CustomerDetails")
     * @Annotation\SerializedName("CustomerDetails")
     */
    private $customerDetails;

    /**
     * Action constructor.
     *
     * @param ScreeningAction       $service
     * @param MerchantConfiguration $merchantConfiguration
     * @param CustomerDetails       $customerDetails
     */
    public function __construct(
        ScreeningAction $service,
        MerchantConfiguration $merchantConfiguration,
        CustomerDetails $customerDetails
    ) {
        $this->service = $service;
        $this->merchantConfiguration = $merchantConfiguration;
        $this->customerDetails = $customerDetails;
    }

    /**
     * Service getter.
     *
     * @return ScreeningAction
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Service setter.
     *
     * @param ScreeningAction $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * MerchantConfiguration getter.
     *
     * @return MerchantConfiguration
     */
    public function getMerchantConfiguration()
    {
        return $this->merchantConfiguration;
    }

    /**
     * MerchantConfiguration setter.
     *
     * @param MerchantConfiguration $merchantConfiguration
     */
    public function setMerchantConfiguration($merchantConfiguration)
    {
        $this->merchantConfiguration = $merchantConfiguration;
    }

    /**
     * CustomerDetails getter.
     *
     * @return CustomerDetails
     */
    public function getCustomerDetails()
    {
        return $this->customerDetails;
    }

    /**
     * CustomerDetails setter.
     *
     * @param CustomerDetails $customerDetails
     */
    public function setCustomerDetails($customerDetails)
    {
        $this->customerDetails = $customerDetails;
    }
}
