<?php

namespace Max\LoyaltyProgram\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Max\LoyaltyProgram\Helper\Data;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;


class Edit extends Action implements HttpGetActionInterface
{
    protected $pageFactory;
    protected $request;
    protected $helper;
    protected $resultForwardFactory;
    
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Data $helper,
        ForwardFactory $resultForwardFactory
    )
    {
        $this->resultForwardFactory = $resultForwardFactory;
        $this->helper = $helper;
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        if (!$this->helper->isEnable()) {
            return $this->resultForwardFactory->create()->forward('defaultNoRoute');
        }
        return $this->pageFactory->create();
    }
}
