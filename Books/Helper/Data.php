<?php

namespace Max\Books\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends AbstractHelper
{
    const XML_PATH_IS_ENABLE = 'books/general/enable';
    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnable() {
        return $this->scopeConfig->getValue(self::XML_PATH_IS_ENABLE);
    }

}
