<?php

namespace Max\Books\Controller\Adminhtml\Index;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;


class View implements HttpGetActionInterface
{
    protected $result;
    public function __construct(

        PageFactory $result
    )
    {

        $this->result = $result;
    }

    public function execute()
    {
        $resultPage = $this->result->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Books')));
        return $resultPage;
    }

}
