<?php

namespace Max\Books\Model;

use Max\Books\Model\ResourceModel\ResourceBooks;
use Max\Books\Model\BooksFactory;

class BooksRepository
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
    
    public function delete($book) {
        $this->resource->delete($book);
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
    public function save($book)
    {
        $this->resource->save($book);
        return $book;
    }

}
