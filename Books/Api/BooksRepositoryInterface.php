<?php
namespace Max\Books\Api;

use Max\Books\Api\Data\BooksInterface;

interface BooksRepositoryInterface {
    public function delete(BooksInterface $book);
    public function deleteById($bookId);
    public function getById($bookId);
    public function save(BooksInterface $book);
}
