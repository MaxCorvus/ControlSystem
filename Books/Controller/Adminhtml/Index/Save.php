<?php

namespace Max\Books\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Max\Books\Model\BooksRepository;

class Save implements HttpPostActionInterface
{
    protected $result;
    protected $booksRepository;
    protected $request;
    protected $messageManager;

    public function __construct(
        ResultFactory    $result,
        BooksRepository  $booksRepository,
        RequestInterface $request,
        ManagerInterface $messageManager
    )
    {
        $this->result = $result;
        $this->booksRepository = $booksRepository;
        $this->request = $request;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        try {
            
            $data = $this->request->getPostValue();

            if (isset($data['id'])) {
                $book = $this->booksRepository->getById($data['id']);
                $book->addData($data);
                $this->booksRepository->save($book);
            } else {
                $model = $this->booksRepository->getInstance();
                $model->setData($data);
                
                $this->booksRepository->save($model);
            }
            $this->messageManager->addSuccessMessage(__("Success"));
        }
        catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("Save error"));
        }
        
        $result = $this->result->create(ResultFactory::TYPE_REDIRECT)->setPath('books/index/view');
        return $result;
    }
}
