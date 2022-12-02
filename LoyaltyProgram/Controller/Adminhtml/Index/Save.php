<?php

namespace Max\LoyaltyProgram\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Max\LoyaltyProgram\Model\CoinRepository;
use Magento\Framework\App\RequestInterface;
use Max\LoyaltyProgram\Helper\Data;

class Save extends Action implements HttpPostActionInterface
{
    protected $pageFactory;
    protected $request;
    protected $helper;
    protected $resultForwardFactory;
    protected $coinRepository;
    protected $result;

    public function __construct(
        Context $context,
        ResultFactory  $result,
        PageFactory $pageFactory,
        Data $helper,
        ForwardFactory $resultForwardFactory,
        CoinRepository $coinRepository,
        RequestInterface $request
    )
    {
        $this->result = $result;
        $this->request = $request;
        $this->coinRepository = $coinRepository;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->helper = $helper;
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {

       $id = $this->request->getParam('general')['id'];
//       $customerId = $this->request->getParam('general')['customer_id'];
       return $this->result->create(ResultFactory::TYPE_REDIRECT)->setPath('coins/index/coins', ['id' => $id]);
        
    }
}
