<?php

namespace Max\LoyaltyProgram\Controller\Adminhtml\Index;

use Magento\Customer\Controller\Adminhtml\Index;

class Coins extends Index
{
    public function execute()
    {
        $this->initCurrentCustomer();
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
