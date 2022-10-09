<?php

namespace Max\Books\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Max\Books\Api\BooksRepositoryInterface;
use Max\Books\Api\Data\BooksInterface;
use Max\Books\Model\ResourceModel\ResourceBooks;
use Max\Books\Model\BooksFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Max\Books\Model\ResourceModel\Books\CollectionFactory;
use Max\Books\Api\Data\BooksSearchResultsInterfaceFactory;


class BooksRepository implements BooksRepositoryInterface
{
    private $resource;
    private $booksFactory;
    protected $collectionProcessor;
    protected $collectionFactory;
    protected $searchResultsFactory;
    
    public function __construct(
        ResourceBooks $resource,
        BooksFactory $booksFactory,
        CollectionProcessor $collectionProcessor,
        CollectionFactory $collectionFactory,
        BooksSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->booksFactory = $booksFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    public function delete(BooksInterface $book) {
        try {
            $this->resource->delete($book);
        }
        catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;

    }
    public function deleteById($bookId)
    {
        return $this->delete($this->getById($bookId));
    }
    public function getById($bookId)
    {
        $book = $this->booksFactory->create();
        $this->resource->load($book, $bookId);
        return $book;
    }
    public function save(BooksInterface $book)
    {
        try {
            $this->resource->save($book);
        }
        catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $book;
    }
    public function getInstance()
    {
        return $this->booksFactory->create();
    }
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $searchResult = $this->searchResultsFactory->create();
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }
}
