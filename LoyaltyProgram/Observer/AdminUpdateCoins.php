<?php

namespace Max\LoyaltyProgram\Observer;


use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Max\LoyaltyProgram\Model\CoinRepository;

class AdminUpdateCoins implements ObserverInterface
{
    protected $request;
    
    public function __construct(
        RequestInterface $request,
        CoinRepository $coinRepository
    ) {
        $this->coinRepository = $coinRepository;
        $this->request = $request;
    }

    public function execute(Observer $observer)
    {
        $data = $this->request->getParam('general')['id'];
        
    var_dump($data); die;
    }
}
