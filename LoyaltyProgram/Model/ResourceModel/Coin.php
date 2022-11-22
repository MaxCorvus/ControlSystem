<?php

namespace Max\LoyaltyProgram\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Coin extends AbstractDb
{
    private const TABLE_NAME = 'coins';
    private const PRIMARY_KEY = 'id';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::PRIMARY_KEY);
    }

}
