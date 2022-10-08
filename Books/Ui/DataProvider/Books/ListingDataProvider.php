<?php

namespace Max\Books\Ui\DataProvider\Books;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Max\Books\Model\ResourceModel\Books\CollectionFactory;

class ListingDataProvider extends AbstractDataProvider
{
    private CollectionFactory $collectionFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }
        $books = $this->getCollection()->toArray();

        return $books;
    }
}
