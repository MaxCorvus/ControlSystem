<?php

namespace Max\LoyaltyProgram\Block\Adminhtml\Customer\Edit\Tab\View;
use Magento\Backend\Block\Widget\Grid\Extended;
use Max\LoyaltyProgram\Model\ResourceModel\Coin\CollectionFactory;
use Magento\Framework\App\RequestInterface;


class CoinsTab extends Extended
{
    protected $collectionFactory;
    protected $request;
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        array $data = []
    ) {
        $this->request = $request;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _prepareCollection()
    {
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('customer_id', $this->request->getParam('id'))
            ->setOrder('insertion_date', 'desc');

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            
            'occasion',
            [
                'index'  => 'order_id',
                'header' => __('Occasion')
            ]
        );

        $this->addColumn(
            'amount_of_purchase',
            [
                'index'    => 'amount_of_purchase',
                'header'   => __('Amount of Purchase'),
                'type'     => 'currency',
            ]
        );

        $this->addColumn(
            'coins_received',
            [
                'index'  => 'coins_received',
                'header' => __('Coins Received'),
                'type'   => 'number',
            ]
        );

        $this->addColumn(
            'coins_spend',
            [
                'index'  => 'coins_spend',
                'header' => __('Coins Spend'),
                'type'   => 'number',
            ]
        );

        $this->addColumn(
            'date_of_purchase',
            [
                'index'  => 'insertion_date',
                'header' => __('Date of Purchase'),
                'type'   => 'datetime'
            ]
        );
        $this->addColumn(
            'action',
            [
                'header' => __('Edit'),
                'width'     => '100px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => [
                    [
                        'caption' => __('Edit'),
                        'url' => ['base' => 'coins/index/edit'],
                        'field'   => 'id'   // pass id as parameter
                    ]
                ],
                'filter'    => false,
                'sortable'  => false,
                'index' => 'id',
                'is_system' => true
            ]
        );
        

        return parent::_prepareColumns();
    }

    
}
