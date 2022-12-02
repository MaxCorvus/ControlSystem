<?php

namespace Max\LoyaltyProgram\ViewModel;

use Magento\Framework\Url;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class CoinsList implements ArgumentInterface
{
    public $coinsCollection;
    protected $urlBuilder;

    public function __construct(
        CollectionFactory $collection,
        Url               $urlBuilder
    )
    {
        $this->coinsCollection = $collection;
        $this->urlBuilder = $urlBuilder;
    }

    public function getCoinsCollection()
    {
        return $this->coinsCollection->create()->getItems();

    }

    public function getEmptyMessage()
    {
        return __('There are no entries here yet');
    }

}
