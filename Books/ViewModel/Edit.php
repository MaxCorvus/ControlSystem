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
        BookRepository $repository,


    ) {
        $this->request = $request;
        $this->bookRepository = $repository;
    }

    public function getAllData() {
        $id = $this->request->getParam('id');
        $book = $this->bookRepository->getById($id);
        return $book;
    }

}
