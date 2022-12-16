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

        $streetTable = $setup->getConnection()
            ->newTable($setup->getTable(Street::TABLE_NAME))
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
                'Street ID'
            )
            ->addColumn(
                'ref',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false,
                ],
                'Street Ref'
            )
            ->addColumn(
                'city_ref',
                Table::TYPE_TEXT,
                36,
                [
                    'nullable' => false
                ],
                'City Ref'
            )
            ->addColumn(
                'description',
                Table::TYPE_TEXT,
                99,
                [],
                'Street Name'
            )
            ->addColumn(
                'street_type',
                Table::TYPE_TEXT,
                99,
                [],
                'Street Type'
            )
            ->addColumn(
                'street_type_ref',
                Table::TYPE_TEXT,
                36,
                [],
                'Street Type Ref'
            )
            ->addIndex(
                $setup->getIdxName(Street::TABLE_NAME, ['ref'], AdapterInterface::INDEX_TYPE_UNIQUE),
                ['ref'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            );
        $setup->getConnection()->createTable($streetTable);

        $setup->endSetup();
    }
}
