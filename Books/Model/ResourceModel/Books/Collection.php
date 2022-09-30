<?php

namespace Max\Books\Model\ResourceModel\Books;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'book_id';
    
    protected function _construct()
    {
        $this->_init(
            'Max\Books\Model\Books',
            'Max\Books\Model\ResourceModel\ResourceBooks'
        );
    }
}
