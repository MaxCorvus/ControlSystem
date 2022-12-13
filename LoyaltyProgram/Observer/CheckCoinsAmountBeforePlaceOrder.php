<?php

namespace Max\LoyaltyProgram\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;
use Max\LoyaltyProgram\Helper\Data;
use Max\LoyaltyProgram\Model\Config\Settings;

class CheckCoinsAmountBeforePlaceOrder implements ObserverInterface
{
    protected $helper;
    protected $messageManager;

    public function __construct(
        ManagerInterface $messageManager,
        Data $helper
    ) {
        $this->messageManager = $messageManager;
        $this->helper = $helper;
    }

    public function execute(Observer $observer)
    {
        $paymentMethod = $observer->getOrder()->getPayment()->getMethod();

        if ($paymentMethod == Settings::CODE) {
            if (!$this->helper->isEnable() && !$this->helper->isLoggedIn()) {
                return;
            }
            $order = $observer->getEvent()->getOrder();
            $customer = $observer->getQuote()->getCustomer();
            $customerCoinsValue = $customer->getCustomAttribute('coins')?->getValue();
            $baseGrandTotal = $order->getBaseGrandTotal();
            if ($customerCoinsValue < $baseGrandTotal) {
                throw new \Exception('You don\'t have enough coins');
            }
        }
    }
}
