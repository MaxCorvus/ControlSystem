<?php

namespace Max\LoyaltyProgram\Model\ResourceModel\Coin;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Max\LoyaltyProgram\Model\Coin;
use Max\LoyaltyProgram\Model\ResourceModel\Coin as CoinResource;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    
    protected function _construct()
    {
        $this->_init(Coin::class, CoinResource::class);
    }

}
