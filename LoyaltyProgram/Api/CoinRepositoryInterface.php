<?php

namespace Max\LoyaltyProgram\Api;

use Max\Books\Api\Data\BooksInterface;
use Max\LoyaltyProgram\Api\Data\CoinInterface;

interface CoinRepositoryInterface
{
    public function delete(CoinInterface $coin);
    public function deleteById($coinId);
    public function getById($coinId);
    public function save(CoinInterface $coin);
}
