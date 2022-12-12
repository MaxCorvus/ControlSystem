<?php

namespace Max\LoyaltyProgram\Model;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Max\LoyaltyProgram\Api\CoinRepositoryInterface;
use Max\LoyaltyProgram\Model\ResourceModel\Coin\CollectionFactory;
use Max\LoyaltyProgram\Helper\Data;

class DataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $coinRepository;
    protected $request;
    protected $loadedData;
    protected $dataPersistor;
    protected $helper;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        CoinRepositoryInterface $coinRepository,
        RequestInterface $request,
        DataPersistorInterface $dataPersistor,
        Data $helper,
        array $meta = [],
        array $data = []
    )
    {
        $this->helper = $helper;
        $this->collection = $collectionFactory->create();
        $this->coinRepository = $coinRepository;
        $this->request = $request;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData(): array
    {
        $customerId = (int)$this->request->getParam('id');
        $customerData = $this->coinRepository->getById($customerId);
        if ($customerData === null) {
            return [];
        }
        
        return [$customerData['id'] => ['general' => $customerData->getData()]];
    }
}
