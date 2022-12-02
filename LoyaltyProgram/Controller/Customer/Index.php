<?php

namespace Max\LoyaltyProgram\Controller\Customer;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Max\LoyaltyProgram\Helper\Data;
use Magento\Framework\Controller\Result\ForwardFactory;

class Index implements HttpGetActionInterface
{

    protected $pageFactory;
    protected $helper;
    protected $resultForwardFactory;
    /**
     * Index constructor.
     *
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    public function __construct(
        PageFactory $pageFactory,
        Data $helper,
        ForwardFactory $resultForwardFactory
    )
    {
        $this->pageFactory = $pageFactory;
        $this->helper = $helper;
        $this->resultForwardFactory = $resultForwardFactory;
    }

    public function execute()
    {
        if (!$this->helper->isEnable()) {
            return $this->resultForwardFactory->create()->forward('defaultNoRoute');
        }
        return $this->pageFactory->create();
    }
}
