<?php

namespace Max\LoyaltyProgram\ViewModel;

use Magento\Framework\Url;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Max\LoyaltyProgram\Model\ResourceModel\Coin\CollectionFactory;
use Max\LoyaltyProgram\Helper\Data;
use Magento\Customer\Model\Session;

class CoinsList implements ArgumentInterface
{
    public $coinsCollection;
    protected $urlBuilder;
    protected $helper;
    protected $session;

    public function __construct(
        CollectionFactory $collection,
        Url               $urlBuilder,
        Data $helper,
        Session $session
    )
    {
        $this->session = $session;
        $this->helper = $helper;
        $this->coinsCollection = $collection;
        $this->urlBuilder = $urlBuilder;
    }

    public function getCoinsCollection()
    {
        return $this->coinsCollection->create()->addFieldToFilter('customer_id', $this->session->getCustomerId())->getItems();

    }

    public function getEmptyMessage()
    {
        return __('There are no entries here yet');
    }
    
    public function getAmountOfCoins() {
        
     return $this->helper->getCurrentCustomerCoinsAmount();
     
    }

}
