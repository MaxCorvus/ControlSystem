<?php
namespace Max\Books\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Max\Books\Model\BooksRepository;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;

class Delete implements HttpGetActionInterface
{
    protected $booksRepository;
    protected $request;
    protected $result;
    
    public function __construct(
        BooksRepository $booksRepository,
        RequestInterface $request,
        ResultFactory $result
    ) 
    {
        $this->booksRepository = $booksRepository;
        $this->request = $request;
        $this->result = $result;
    }
    public function execute()
    {
        $id = $this->request->getParam('id');
        $this->booksRepository->deleteById($id);
        $result = $this->result->create(ResultFactory::TYPE_REDIRECT)->setPath('books/index/view');
        return $result;
    }
    
}