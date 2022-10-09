<?php

namespace Max\Books\Controller\Index;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Max\Books\Helper\Data;
use Magento\Framework\Controller\Result\ForwardFactory;

class View implements HttpGetActionInterface
{
    protected $pageFactory;
    protected $helper;

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
            return $this->resultForwardFactory->create()->forward('noRoute');
        }
        return $this->pageFactory->create();
    }
}
