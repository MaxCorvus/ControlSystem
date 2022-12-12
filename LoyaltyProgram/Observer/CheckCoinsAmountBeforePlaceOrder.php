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
        if (!$this->helper->isEnable() && !$this->helper->isLoggedIn()) {
            return;
        }
        $paymentMethod = $observer->getOrder()->getPayment()->getMethod();
        $coinsAmount = $this->helper->getCurrentCustomerCoinsAmount();

        if ($paymentMethod == Settings::CODE) {
            $order = $observer->getEvent()->getOrder();
            $baseSubTotal = $order->getBaseSubTotal();
            if ($coinsAmount < $baseSubTotal) {
                throw new \Exception('You don\'t have enough coins');
            }
        }
    }
}
