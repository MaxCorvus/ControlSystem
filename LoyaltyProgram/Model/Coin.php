<?php

namespace Max\LoyaltyProgram\Model;

use Magento\Framework\Model\AbstractModel;
use Max\LoyaltyProgram\Model\ResourceModel\Coin as CoinResource;
use Max\LoyaltyProgram\Api\Data\CoinInterface;

class Coin extends AbstractModel implements CoinInterface
{
    protected function _construct()
    {
        $this->_init(CoinResource::class);
    }
    public function getId()
    {
        return $this->getData(self::COINS_ID);
    }
    
    public function getOrderId()
    {
        return $this->getData(self::COINS_ORDER_ID);
    }
    
    public function getCustomerId()
    {
        return $this->getData(self::COINS_CUSTOMER_ID);
    }
    
    public function getCoins()
    {
        return $this->getData(self::COINS_COINS_AMOUNT);
    }
   
    public function getInsertionDate()
    {
        return $this->getData(self::COINS_INSERTION_DATE);
    }

    
    public function setId($id)
    {
        return $this->setData(self::COINS_ID, $id);
    }
   
    public function setOrderId($orderId)
    {
        return $this->setData(self::COINS_ORDER_ID, $orderId);
    }
    
    public function setCustomerId($customerId)
    {
        return $this->setData(self::COINS_CUSTOMER_ID, $customerId);
    }
    
    public function setCoins($coinsAmount)
    {
        return $this->setData(self::COINS_COINS_AMOUNT, $coinsAmount);
    }
    
    public function setInsertionDate($insertionDate)
    {
        return $this->setData(self::COINS_INSERTION_DATE, $insertionDate);
    }
}
