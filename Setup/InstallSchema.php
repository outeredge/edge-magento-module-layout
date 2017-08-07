<?php

namespace OuterEdge\Layout\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $tableGroups = $installer->getTable('layout_groups');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableGroups) != true) {
            // Create table
            $table = $installer->getConnection()
                ->newTable($tableGroups)
                ->addColumn(
                    'group_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'Id'
                )
                ->addColumn(
                    'group_code',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => null],
                    'Group Code'
                )
                ->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true, 'default' => null],
                    'Title'
                )
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true, 'default' => null],
                    'Description'
                )
                ->addColumn(
                    'sort_order',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Sort Order'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => true, 'default' => Table::TIMESTAMP_UPDATE],
                    'Updated At'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => true],
                    'Created At'
                )
                ->addIndex(
                    $installer->getIdxName(
                        'layout_groups',
                        ['group_code'],
                        AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['group_code'],
                    ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->setComment('Layout Group Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        $tableElements = $installer->getTable('layout_elements');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableElements) != true) {
            // Create table
            $table = $installer->getConnection()
                ->newTable($tableElements)
                ->addColumn(
                    'element_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary'  => true
                    ],
                    'Id'
                )
                ->addColumn(
                    'group_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false
                    ],
                    'Fk Group'
                )
                ->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => true],
                    'Title'
                )
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Description'
                )
                ->addColumn(
                    'link',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Link'
                )
                ->addColumn(
                    'link_text',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Link Text'
                )
                ->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => true],
                    'Image'
                )
                ->addColumn(
                    'sort_order',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Sort Order'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => true, 'default' => Table::TIMESTAMP_UPDATE],
                    'Updated At'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => true ],
                    'Created At'
                )
                ->addForeignKey(
                    $installer->getFkName('layout_elements', 'group_id', 'layout_groups', 'group_id'),
                    'group_id',
                    $installer->getTable('layout_groups'),
                    'group_id',
                    Table::ACTION_CASCADE
                )
                ->setComment('Elements Group Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
