<?php

namespace Max\Books\ViewModel;

use Magento\Framework\Url;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Max\Books\Model\ResourceModel\Books\CollectionFactory;

class Book implements ArgumentInterface
{
    public $booksCollectionFactory;
    protected $urlBuilder;

    public function __construct(
        CollectionFactory $collection,
        Url               $urlBuilder
    )
    {
        $this->booksCollectionFactory = $collection;
        $this->urlBuilder = $urlBuilder;
    }

    public function getBooksCollection()
    {
        return $this->booksCollectionFactory->create()->getItems();

    }

}