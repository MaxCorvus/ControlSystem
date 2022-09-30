<?php
namespace Max\Books\Model;

use Magento\Framework\Model\AbstractModel;
use Max\Books\Model\ResourceModel\ResourceBooks;

class Books extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceBooks::class);
    }
}
