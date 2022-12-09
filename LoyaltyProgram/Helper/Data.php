<?php

namespace Max\LoyaltyProgram\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Helper\Context;
use Max\LoyaltyProgram\Model\CoinRepository;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Message\ManagerInterface;

class Data extends AbstractHelper
{
    public const XML_PATH_MODULE_ENABLE = 'loyalty_program/general/enable';
    public const XML_PATH_SHOW_MESSAGE = 'loyalty_program/general/show_message';
    public const XML_PATH_PURCHASE_PERCENT = 'loyalty_program/general/purchase_percent';
    protected $request;
    protected $coinRepository;
    public $session;
    protected $customerRepository;
    protected $httpContext;
    protected $messageManager;

    public function __construct(
        Context $context,
        RequestInterface $request,
        CoinRepository $coinRepository,
        Session $session,
        CustomerRepositoryInterface $customerRepository,
        HttpContext $httpContext,
        ManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
        $this->httpContext = $httpContext;
        $this->customerRepository = $customerRepository;
        $this->session = $session;
        $this->coinRepository = $coinRepository;
        $this->request = $request;
        parent::__construct($context);
    }

    public function isEnable()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_MODULE_ENABLE);
    }

    public function isShowMessage()
    {
        if ($this->isEnable()) {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SHOW_MESSAGE);
            }
        return false;
    }

    public function calculateReceivedCoins($price)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_PURCHASE_PERCENT) * $price / 100;
    }

    public function getCustomerId()
    {
        return $this->session->getCustomerId();
    }

    public function isLoggedIn()
    {
        $isLoggedIn = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        return $isLoggedIn;
    }

    public function getCurrentCustomerCoinsAmount() {

        $customerId = $this->getCustomerId();
        if ($customerId) {
            $customer = $this->customerRepository->getById($customerId);
            $coinsAmount =  $customer->getCustomAttribute('coins')->getValue();
            return round($coinsAmount, 1);
        }
    }

    public function updateCoinsValue($id, $orderId, $customerId, $coinsReceived, $coinsSpend) {
        try {
            $data = $this->coinRepository->getById($id);
            $customer = $this->customerRepository->getById($customerId);
        }
        catch (NoSuchEntityException|LocalizedException) {
            throw new NotFoundException(__('User Not Found'));
        }

        $differenceCoinsReceived = $coinsReceived - $data->getCoinsReceived();
        $differenceCoinsSpend = $coinsSpend - $data->getCoinsSpend();
        $coinsAmount =  $customer->getCustomAttribute('coins')->getValue();
        $customer->setCustomAttribute('coins', $coinsAmount + $differenceCoinsReceived - $differenceCoinsSpend);

        $data->setCoinsReceived($coinsReceived);
        $data->setCoinsSpend($coinsSpend);
        $data->setOrderId($orderId);
        $data->setUpdatedAt(date('d/m/y H:i:s'));

        try {
            $this->customerRepository->save($customer);
            $this->coinRepository->save($data);
            $this->messageManager->addSuccessMessage(__('Success'));
        }
        catch (CouldNotSaveException|LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong.'));
        }

    }

}
