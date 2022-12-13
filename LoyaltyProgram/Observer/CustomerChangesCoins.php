<?php

namespace Max\LoyaltyProgram\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Max\LoyaltyProgram\Api\CoinRepositoryInterface;
use Max\LoyaltyProgram\Helper\Data;
use Max\LoyaltyProgram\Model\CoinFactory;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Max\LoyaltyProgram\Model\Config\Settings;
use Magento\Framework\Message\ManagerInterface;

class CustomerChangesCoins implements ObserverInterface
{
    protected $helper;
    protected $coinFactory;
    protected $customerRepository;
    protected $coinRepository;
    protected $messageManager;

    public function __construct(
        ManagerInterface $messageManager,
        Data $helper,
        CoinFactory $coinFactory,
        CustomerRepository $customerRepository,
        CoinRepositoryInterface $coinRepository
    ) {
        $this->messageManager = $messageManager;
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
        $baseSubTotal = $order->getBaseSubTotal();
        $baseGrandTotal = $order->getBaseGrandTotal();
        $customer = $observer->getQuote()->getCustomer();
        $customerId = $order->getCustomerId();
        $coinsReceived = $this->helper->calculateReceivedCoins($baseSubTotal);

        $transaction = $this->coinFactory->create();
        $transaction->setCustomerId($customerId)
                    -> setOrderId($orderId)
                    -> setAmountOfPurchase($baseSubTotal)
                    -> setInsertionDate($createdAt);
        
        if ($paymentMethod == Settings::CODE) {
            $coinsAmountChange = -$baseGrandTotal;
            $transaction->setCoinsSpend($baseGrandTotal);
        }
        else {
            $coinsAmountChange = $coinsReceived;
            $transaction->setCoinsReceived($coinsReceived);
        }
        

        $customerCoinsValue = $customer->getCustomAttribute('coins')?->getValue() ?? 0;
        $newCustomerCoinsValue = $customerCoinsValue + $coinsAmountChange;
        $customer->setCustomAttribute('coins', $newCustomerCoinsValue);

        try {
            $this->coinRepository->save($transaction);
            $this->customerRepository->save($customer);
            $this->messageManager->addSuccessMessage(__('Success'));
        }
        catch (CouldNotSaveException|LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong.'));
        }
    }
}
