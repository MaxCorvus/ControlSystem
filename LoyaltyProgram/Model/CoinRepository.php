<?php

namespace Max\LoyaltyProgram\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Max\LoyaltyProgram\Model\ResourceModel\Coin as CoinResource;
use Max\LoyaltyProgram\Api\CoinRepositoryInterface;
use Max\LoyaltyProgram\Api\Data\CoinInterface;
use Max\LoyaltyProgram\Model\CoinFactory;
use Max\LoyaltyProgram\Model\ResourceModel\Coin\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;

class CoinRepository implements CoinRepositoryInterface
{
    private $resource;
    public $coinsFactory;
    protected $collectionFactory;
    protected $collectionProcessor;

    public function __construct(
        CoinResource $resource,
        CoinFactory $coinsFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessor $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->coinsFactory = $coinsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function delete(CoinInterface $coin)
    {
        try {
            $this->resource->delete($coin);
        }
        catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }

    public function deleteById($coinId)
    {
        return $this->delete($this->getById($coinId));
    }

    public function getById($coinId)
    {
        $coin = $this->coinsFactory->create();
        $this->resource->load($coin, $coinId);
        if (!$coin->getId()) {
            throw new NoSuchEntityException(__('No such id exists'));
        }
        return $coin;
    }

    public function save(CoinInterface $coin)
    {
        try {
            $this->resource->save($coin);
        }
        catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $coin;
    }
}
