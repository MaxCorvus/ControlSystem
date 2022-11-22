<?php

namespace Max\LoyaltyProgram\Api\Data;

interface CoinInterface
{
    const COINS_ID = 'id';
    const COINS_CUSTOMER_ID = 'customer_id';
    const COINS_ORDER_ID = 'order_id';
    const COINS_COINS_AMOUNT = 'coins_amount';
    const COINS_INSERTION_DATE = 'insertion_date';

    public function getId();
    public function getOrderId();
    public function getCustomerId();
    public function getCoins();
    public function getInsertionDate();
    public function setId($id);
    public function setOrderId($orderId);
    public function setCustomerId($customerId);
    public function setCoins($coinsAmount);
    public function setInsertionDate($insertionDate);
}
