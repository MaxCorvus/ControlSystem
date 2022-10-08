<?php

namespace Max\Books\Model;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Max\Books\Model\ResourceModel\Books\CollectionFactory;
use Max\Books\Model\BooksRepository;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class DataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $booksRepository;
    protected $request;
    protected $loadedData;
    protected $dataPersistor;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        BooksRepository $booksRepository,
        RequestInterface $request,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        $this->booksRepository = $booksRepository;
        $this->request = $request;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $id = (int)$this->request->getParam('id');

        if (isset($id)) {

            
                $book = $this->booksRepository->getById($id);
            
            return [
                    $book->getData()
            ];

        }
        return [];
    }
}

