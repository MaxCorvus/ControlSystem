<?php

namespace Max\LoyaltyProgram\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\ResourceModel\Attribute as AttributeResource;
use Magento\Customer\Controller\Adminhtml\Index\InlineEdit;

class CustomerCoinsAttribute implements DataPatchInterface
{
    protected $moduleDataSetup;
    protected $eavSetup;
    protected $config;
    protected $attributeResource;
    const ATTRIBUTE_CODE = 'coins';
    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        Config $config,
        AttributeResource $attributeResource
    ) {
        $this->attributeResource = $attributeResource;
        $this->config = $config;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetup = $eavSetupFactory->create(['setup' => $moduleDataSetup]);
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->eavSetup->addAttribute(
            Customer::ENTITY,
            self::ATTRIBUTE_CODE,
            [
                'label' => 'Amount of coins',
                'visible' => 1,
                'required' => 0,
                'position' => 100,
                'system' => 0,
                'default' => 0,
                'user_defined' => 1,
                'is_used_in_grid' => 1,
                'is_visible_in_grid' => 1,
                'is_filterable_in_grid' => 0,
                'is_searchable_in_grid' => 0,
                'type' => 'decimal'
            ]
        );
        $this->eavSetup->addAttributeToSet(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER,
            'Default',
            self::ATTRIBUTE_CODE
        );
        
        $attribute = $this->config->getAttribute(Customer::ENTITY, self::ATTRIBUTE_CODE);
        
        $attribute->setData('used_in_forms', [
            'adminhtml_customer'
        ]);

        $this->attributeResource->save($attribute);
        
        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
