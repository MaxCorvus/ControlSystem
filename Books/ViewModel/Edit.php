<?php

namespace Max\Books\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\RequestInterface;
use Max\Books\Model\BooksRepository;

class Edit implements ArgumentInterface
{
    protected $bookRepository;
    protected $request;
    public function __construct(
        RequestInterface $request,
        BooksRepository $repository,


    ) {
        $this->request = $request;
        $this->bookRepository = $repository;
    }

    public function getBook() {
        $id = $this->request->getParam('id');
        if ($id){
        $book = $this->bookRepository->getById($id);
        return $book;
        }
        return $this->bookRepository->getInstance();
        
    }

}
