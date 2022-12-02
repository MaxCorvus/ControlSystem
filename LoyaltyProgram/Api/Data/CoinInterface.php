<?php

namespace Max\LoyaltyProgram\Api\Data;

interface CoinInterface
{
    const COINS_ID = 'id';
    const COINS_CUSTOMER_ID = 'customer_id';
    const COINS_ORDER_ID = 'order_id';
    const COINS_AMOUNT_OF_PURCHASE = 'amount_of_purchase';
    const COINS_COINS_RECEIVED = 'coins_received';
    const COINS_COINS_SPEND = 'coins_spend';
    const COINS_INSERTION_DATE = 'insertion_date';

    public function getId();
    public function getOrderId();
    public function getCustomerId();
    public function getAmountOfPurchase();
    public function getCoinsReceived();
    public function getCoinsSpend();
    public function getInsertionDate();
    public function setId($id);
    public function setOrderId($orderId);
    public function setCustomerId($customerId);
    public function setAmountOfPurchase($amountOfPurchase);
    public function setCoinsReceived($coinsReceived);
    public function setCoinsSpend($coinsSpend);
    public function setInsertionDate($insertionDate);
}
