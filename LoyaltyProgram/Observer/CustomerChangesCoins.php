<?php

namespace Max\LoyaltyProgram\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Max\LoyaltyProgram\Helper\Data;
use Max\LoyaltyProgram\Model\CoinFactory;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Max\LoyaltyProgram\Model\CoinRepository;
use Max\LoyaltyProgram\Model\Config\Settings;

class CustomerChangesCoins implements ObserverInterface
{
    protected $helper;
    protected $coinFactory;
    protected $customerRepository;
    protected $coinRepository;

    public function __construct(
        Data $helper,
        CoinFactory $coinFactory,
        CustomerRepository $customerRepository,
        CoinRepository $coinRepository
    ) {
        $this->coinRepository = $coinRepository;
        $this->customerRepository = $customerRepository;
        $this->coinFactory = $coinFactory;
        $this->helper = $helper;
    }

    public function execute(Observer $observer)
    {
        if (!$this->helper->isEnable()) {
            return;
        }
        $paymentMethod = $observer->getOrder()->getPayment()->getMethod();

        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getId();
        $createdAt =  $order->getCreatedAt();
        $basegrandTotal = $order->getBaseGrandTotal();
        $customer = $observer->getQuote()->getCustomer();
        $customerId = $order->getCustomerId();
        $coinsReceived = $this->helper->calculateReceivedCoins($basegrandTotal);

        $transaction = $this->coinFactory->create();
        $transaction->setCustomerId($customerId)
                    -> setOrderId($orderId)
                    -> setAmountOfPurchase($basegrandTotal)
                    -> setInsertionDate($createdAt);
        if ($paymentMethod == Settings::CODE) {
            $coinsAmountChange = -$basegrandTotal;
            $transaction->setCoinsSpend($basegrandTotal);
        }
        $coinsAmountChange = $coinsReceived;
        $transaction->setCoinsReceived($coinsReceived);
        $this->coinRepository->save($transaction);

        $customerCoinsValue = $customer->getCustomAttribute('coins')?->getValue() ?? 0;
        $newCustomerCoinsValue = $customerCoinsValue + $coinsAmountChange;
        $customer->setCustomAttribute('coins', $newCustomerCoinsValue);
        $this->customerRepository->save($customer);


    }
}
