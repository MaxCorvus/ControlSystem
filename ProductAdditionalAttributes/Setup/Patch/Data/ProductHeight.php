<?php

namespace Max\ProductAdditionalAttributes\Setup\Patch\Data;

use \Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class ProductHeight implements DataPatchInterface

{
    protected $moduleDataSetup;
    protected $eavSetup;
    protected $logger;
    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        LoggerInterface $logger
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetup = $eavSetupFactory->create(['setup' => $moduleDataSetup]);
        $this->logger = $logger;
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
        $attributeCode = 'height';
        $attributeLabel = 'Height';
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->eavSetup->addAttribute(
            Product::ENTITY,
            $attributeCode,
            [
                'type' => 'int',
                'label' => $attributeLabel,
                'input' => 'text',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'required' => false,
                'visible_on_front' => true,
                'visible' => true,
                'is_used_in_grid' => true,
                ]
        );
        $this->eavSetup->addAttribute(
            Product::ENTITY,
            'isShow',
            [
                'label' => 'Showing of the Product Height On Product Page',
                'type' => 'int',
                'input' => 'boolean',
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'required' => false,
                'sort_order' => 30,
                'is_used_in_grid' => true,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'used_in_product_listing' => true,
                'visible_on_front' => true
            ]
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
