<?php

namespace Max\Books\Api\Data;
use Magento\Framework\Api\SearchResultsInterface;

interface BooksSearchResultsInterface extends SearchResultsInterface {
    public function getItems();
    public function setItems(array $items);
}
