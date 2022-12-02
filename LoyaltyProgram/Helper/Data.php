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
    protected const XML_MODULE_ENABLE = 'loyalty_program/general/enable';
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
        return $this->scopeConfig->isSetFlag(self::XML_MODULE_ENABLE);

    }
    

    public function getCurrentCustomerCoinsAmount() {
        $customerId = $this->session->getCustomerId();
//        var_dump($customerId); die;
        if ($customerId) {
            $customer = $this->customerRepository->getById($customerId);
            $coinsAmount =  $customer->getCustomAttribute('coins')->getValue();
            return round($coinsAmount);
        }
    }
}
