<?php
namespace Max\Books\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Max\Books\Model\BooksRepository;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;

class Delete implements HttpGetActionInterface
{
    protected $booksRepository;
    protected $request;
    protected $result;
    protected $messageManager;

    public function __construct(
        BooksRepository $booksRepository,
        RequestInterface $request,
        ResultFactory $result,
        ManagerInterface $messageManager
    )
    {
        $this->booksRepository = $booksRepository;
        $this->request = $request;
        $this->result = $result;
        $this->messageManager = $messageManager;
    }
    public function execute()
    {
        try {
        $id = $this->request->getParam('id');
        $this->booksRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__("Deletion successful"));
        }
        catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("Deletion failed"));
        }
        $result = $this->result->create(ResultFactory::TYPE_REDIRECT)->setPath('books/index/view');
        return $result;
    }

}
