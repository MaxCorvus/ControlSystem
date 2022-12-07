<?php

namespace Max\LoyaltyProgram\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Helper\Context;
use Max\LoyaltyProgram\Model\CoinRepository;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\CustomerRepositoryInterface;

class Data extends AbstractHelper
{
    public const XML_PATH_MODULE_ENABLE = 'loyalty_program/general/enable';
    public const XML_PATH_SHOW_MESSAGE = 'loyalty_program/general/show_message';
    public const XML_PATH_PURCHASE_PERCENT = 'loyalty_program/general/purchase_percent';
    protected $request;
    protected $coinRepository;
    protected $session;
    protected $customerRepository;

    public function __construct(
        Context $context,
        RequestInterface $request,
        CoinRepository $coinRepository,
        Session $session,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->session = $session;
        $this->coinRepository = $coinRepository;
        $this->request = $request;
        parent::__construct($context);
    }

    public function isEnable()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_MODULE_ENABLE);
    }

    public function isShowMessage()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SHOW_MESSAGE);
    }

    public function calculateReceivedCoins($price)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_PURCHASE_PERCENT) * $price / 100;
    }

    public function getCustomerId()
    {
        return $this->session->getCustomerId();
    }

    public function getCurrentCustomerCoinsAmount() {

        $customerId = $this->getCustomerId();
        if ($customerId) {
            $customer = $this->customerRepository->getById($customerId);
            $coinsAmount =  $customer->getCustomAttribute('coins')->getValue();
            return round($coinsAmount, 1);
        }
    }

    public function updateCoinsValue($id, $orderId, $customerId, $coinsReceived, $coinsSpend) {
        $data = $this->coinRepository->getById($id);
        $differenceCoinsReceived = $coinsReceived - $data->getCoinsReceived();
        $differenceCoinsSpend = $coinsSpend - $data->getCoinsSpend();
        $customer = $this->customerRepository->getById($customerId);
        $coinsAmount =  $customer->getCustomAttribute('coins')->getValue();
        $customer->setCustomAttribute('coins', $coinsAmount + $differenceCoinsReceived - $differenceCoinsSpend);
        $this->customerRepository->save($customer);
        
        $data->setCoinsReceived($coinsReceived);
        $data->setCoinsSpend($coinsSpend);
        $data->setOrderId($orderId);
        $data->setUpdatedAt(date('d/m/y H:i:s'));
        $this->coinRepository->save($data);
        
    }

}
