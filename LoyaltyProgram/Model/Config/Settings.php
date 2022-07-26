<?php

namespace Max\LoyaltyProgram\Model\Config;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Settings implements ConfigProviderInterface
{
    const CODE = 'max_coins';
    const XML_PATH_PAYMENT_ENABLE = 'payment/max_coins/active';
    const CHECKOUT_CONFIG_CODE = 'coins';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var SessionFactory
     */
    private $sessionFactory;

    /**
     * Settings constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param SessionFactory $sessionFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        SessionFactory $sessionFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->sessionFactory = $sessionFactory;
    }

    public function isActive() {

        return (bool) $this->scopeConfig->getValue(self::XML_PATH_PAYMENT_ENABLE);

    }

    public function getConfig()
    {
        /**
         * @var Session $customer
         */
        $customer = $this->sessionFactory->create();
        return [
            'payment' => [
                self::CHECKOUT_CONFIG_CODE => [
                    'enable' => $this->isActive() && $customer->getCustomerId()
                ]
            ]
        ];
    }
}
