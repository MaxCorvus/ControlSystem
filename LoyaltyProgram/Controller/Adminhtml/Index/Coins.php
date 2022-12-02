<?php

namespace Max\LoyaltyProgram\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Customer\Controller\Adminhtml\Index;
use Magento\Framework\Controller\ResultFactory;

class Coins extends Action
{
    public function execute()
    {
        
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        return $resultLayout;
    }
}
