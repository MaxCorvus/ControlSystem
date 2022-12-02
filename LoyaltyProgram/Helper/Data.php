<?php

namespace Max\LoyaltyProgram\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Helper\Context;
use Max\LoyaltyProgram\Model\CoinRepository;
use Magento\Customer\Model\ResourceModel\CustomerRepository;

class Data extends AbstractHelper
{
    protected const XML_MODULE_ENABLE = 'loyalty_program/general/enable';
    protected $request;
    protected $coinRepository;

    public function __construct(
        Context $context,
        RequestInterface $request,
        CoinRepository $coinRepository
    ) {
        $this->coinRepository = $coinRepository;
        $this->request = $request;
        parent::__construct($context);
    }

    public function isEnable()
    { 
        return $this->scopeConfig->isSetFlag(self::XML_MODULE_ENABLE);

    }

    public function getCurrentCustomerId()
    {
        $customerId = (int)$this->request->getParam('id');
        return $customerId;
    }

    public function getCurrentCustomerData()
    {
        $customerData = $this->coinRepository->getById( (int) $this->getCurrentCustomerId());
        return $customerData;
    }
}
