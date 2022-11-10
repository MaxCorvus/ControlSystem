<?php

namespace Max\ShippingMethod\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Checkout\Helper\Cart;
use Psr\Log\LoggerInterface;


class CustomShipping extends AbstractCarrier implements CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'customshipping';
    protected $cartHelper;
    protected $checkoutSession;
    protected array $countryRateList =
        [
        'US' => 3,
	    'UA' => 2,
	    'CA' => 7
        ];
    protected $countryRate;

    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    private $rateResultFactory;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    private $rateMethodFactory;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        CheckoutSession $checkoutSession,
        LoggerInterface $logger,
        Cart $cart,
        $countryRate,
        array $data = []
    ) {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->checkoutSession = $checkoutSession;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->cartHelper = $cart;
        $this->countryRate = $countryRate;
    }

    public function collectRates(RateRequest $request)
    {

        if (!$this->getConfigFlag('enable')) {
            return false;
        }

        $result = $this->rateResultFactory->create();
        $method = $this->rateMethodFactory->create();
        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));
        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('method_name'));
        $shippingPrice = $this->getShippingPrice();
        $method->setPrice($shippingPrice);
        $method->setCost($shippingPrice);

        $result->append($method);
        return $result;

    }

    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('method_name')];
    }


    protected function getShippingPrice()
    {
        $cartTotalPrice = $this->cartHelper->getQuote()->getBaseSubtotal();
        $shippingCost = (float)$this->getConfigData('shipping_cost');
        $countryRate = $this->getCountryRate();
        $numberOfTotalProductsInCart = $this->cartHelper->getItemsQty();
        $numberOfUniqProductsInCart = $this->cartHelper->getItemsCount();
        return ($cartTotalPrice * $numberOfUniqProductsInCart * $shippingCost) / ($numberOfTotalProductsInCart * $countryRate);
    }

    protected function getCountryRate() {
        $shippingAddressId = $this->cartHelper->getQuote()->getShippingAddress()->getCountryId();
        if (array_key_exists($shippingAddressId, $this->countryRateList)) {
            return $this->countryRateList[$shippingAddressId];
        }
        return $this->countryRate;
    }
}


