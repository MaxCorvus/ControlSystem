<?php

namespace Max\Books\Model;

use Max\Books\Api\BooksRepositoryInterface;
use Max\Books\Api\Data\BooksInterface;
use Max\Books\Model\ResourceModel\ResourceBooks;
use Max\Books\Model\BooksFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;

class BooksRepository implements BooksRepositoryInterface
{
    private $resource;
    private $booksFactory;

    public function __construct(
        ResourceBooks $resource,
        BooksFactory $booksFactory
    ) {
        $this->resource = $resource;
        $this->booksFactory = $booksFactory;
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
}
