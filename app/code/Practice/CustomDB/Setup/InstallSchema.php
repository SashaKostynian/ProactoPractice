<?php

namespace Practice\CustomDB\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $customerTable = $setup->getConnection('custom')
            ->newTable($setup->getTable('order_customer'))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ],
                'Customer ID'
            )
            ->addColumn(
                'customer_group',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false,
                ],
                'Customer Group'
            )
            ->addColumn(
                'firstname',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Firstname'
            )
            ->addColumn(
                'middlename',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Middlename'
            )
            ->addColumn(
                'lastname',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Lastname'
            )
            ->addColumn(
                'telephone',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Telephone'
            )
            ->addIndex(
                $setup->getIdxName('order_customer', ['telephone'], AdapterInterface::INDEX_TYPE_INDEX),
                ['telephone'],
                ['type' => AdapterInterface::INDEX_TYPE_INDEX]
            );
        $setup->getConnection()->createTable($customerTable);

        $orderAddressTable = $setup->getConnection('custom')
            ->newTable($setup->getTable('order_address'))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ],
                'Address ID'
            )
            ->addColumn(
                'country',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false,
                ],
                'Country'
            )
            ->addColumn(
                'city',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'City'
            )
            ->addColumn(
                'street',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Street'
            )
            ->addColumn(
                'building',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Building'
            )
            ->addColumn(
                'floor',
                Table::TYPE_TEXT,
                36,
                [],
                'Floor'
            )
            ->addIndex(
                $setup->getIdxName('order_address', ['street'], AdapterInterface::INDEX_TYPE_INDEX),
                ['street'],
                ['type' => AdapterInterface::INDEX_TYPE_INDEX]
            );
        $setup->getConnection()->createTable($orderAddressTable);

        $orderTable = $setup->getConnection('custom')
            ->newTable($setup->getTable('order'))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ],
                'Order ID'
            )
            ->addColumn(
                'customer_id',
                Table::TYPE_TEXT,
                36,
                [],
                'Customer ID'
            )
            ->addColumn(
                'address_id',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Address ID'
            )
            ->addColumn(
                'delivery_method',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Delivery Method'
            )
            ->addColumn(
                'delivery_price',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Delivery Price'
            )
            ->addColumn(
                'payment_method',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Payment Method'
            )
            ->addColumn(
                'total_price',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Total Price'
            )
            ->addIndex(
                $setup->getIdxName('order', ['customer_id'], AdapterInterface::INDEX_TYPE_INDEX),
                ['customer_id'],
                ['type' => AdapterInterface::INDEX_TYPE_INDEX]
            );
        $setup->getConnection()->createTable($orderTable);

        $orderProductTable = $setup->getConnection('custom')
            ->newTable($setup->getTable('order_product'))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ],
                'Product ID'
            )
            ->addColumn(
                'order_id',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false,
                ],
                'Order ID'
            )
            ->addColumn(
                'product_id',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Store Product ID'
            )
            ->addColumn(
                'sku',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'SKU'
            )
            ->addColumn(
                'qnt',
                Table::TYPE_INTEGER,
                36,
                [
                    'nullable' => false
                ],
                'Quantity'
            )
            ->addColumn(
                'price',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Price'
            )
            ->addIndex(
                $setup->getIdxName('order_product', ['customer_id'], AdapterInterface::INDEX_TYPE_INDEX),
                ['order_id'],
                ['type' => AdapterInterface::INDEX_TYPE_INDEX]
            )
            ->addIndex(
                $setup->getIdxName('order_product', ['product_id'], AdapterInterface::INDEX_TYPE_INDEX),
                ['product_id'],
                ['type' => AdapterInterface::INDEX_TYPE_INDEX]
            )
            ->addIndex(
                $setup->getIdxName('order_product', ['sku'], AdapterInterface::INDEX_TYPE_UNIQUE),
                ['sku'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            );
        $setup->getConnection()->createTable($orderProductTable);

        $statisticsTable = $setup->getConnection('custom')
            ->newTable($setup->getTable('product_statistics'))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ],
                'Product ID'
            )
            ->addColumn(
                'sku',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'SKU'
            )
            ->addColumn(
                'qnt',
                Table::TYPE_INTEGER,
                36,
                [
                    'nullable' => false
                ],
                'Quantity'
            )
            ->addColumn(
                'price',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Price'
            )
            ->addColumn(
                'last_day_qnt_sales',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false,
                ],
                'Last day qnt sales'
            )
            ->addColumn(
                'last_week_qnt_sales',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Last week qnt sales'
            )
            ->addColumn(
                'last_month_qnt_sales',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Last month qnt sales'
            )
            ->addColumn(
                'last_day_total_price',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Last day total price'
            )
            ->addColumn(
                'last_week_total_price',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Last week total price'
            )
            ->addColumn(
                'last_month_total_price',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'Last month total price'
            )
            ->addIndex(
                $setup->getIdxName('product_statistics', ['customer_id'], AdapterInterface::INDEX_TYPE_INDEX),
                ['order_id'],
                ['type' => AdapterInterface::INDEX_TYPE_INDEX]
            )
            ->addIndex(
                $setup->getIdxName('product_statistics', ['sku'], AdapterInterface::INDEX_TYPE_UNIQUE),
                ['sku'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            );
        $setup->getConnection()->createTable($statisticsTable);

        $setup->endSetup();
    }
}
