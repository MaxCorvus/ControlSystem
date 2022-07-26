<?php

namespace Max\LoyaltyProgram\Block\Adminhtml\Customer\Edit\Tab;

use Magento\Customer\Controller\RegistryConstants;
use Magento\Ui\Component\Layout\Tabs\TabInterface;
use Magento\Backend\Block\Template;
use Magento\Framework\App\RequestInterface;

class CustomerCoins extends Template implements TabInterface
{

    protected $customerSession;
    protected $_coreRegistry;
    protected $request;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        RequestInterface $request,
        array $data = []
    )
    {   $this->_coreRegistry = $registry;
        $this->request = $request;
        parent::__construct($context, $data);
    }

    public function getTabLabel()
    {
        return __('Customer Coins');
    }

    public function getTabTitle()
    {
        return __('Customer Coins');
    }

    public function canShowTab()
    {
        if ($this->getCustomerId()) {
            return true;
        }
        return false;
    }

    public function getCustomerId()
    {
        return $this->request->getParam('id');
    }

    public function isHidden()
    {
        if ($this->getCustomerId()) {
            return false;
        }
        return true;
    }

    public function getTabClass()
    {
        return '';
    }

    public function getTabUrl()
    {
        return $this->getUrl('coins/*/coins', ['_current' => true]);
    }

    public function isAjaxLoaded()
    {
        return true;
    }
}
