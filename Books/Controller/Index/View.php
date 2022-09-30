<?php

namespace Max\Books\Controller\Index;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;

class View implements HttpGetActionInterface
{
    protected $pageFactory;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    public function __construct(PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        
    }
    
    public function execute()
    {
        return $this->pageFactory->create();
    }
}
