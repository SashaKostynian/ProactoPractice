<?php
namespace Practice\CustomDB\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Ddl\Table;
use Psr\Log\LoggerInterface;

class Index extends Action
{
    private $connection;

    private $logger;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context,
        ResourceConnection $resourceConnection,
        LoggerInterface $logger
    ) {
        $this->connection = $resourceConnection->getConnection('custom');
        $this->logger = $logger;
        parent::__construct($context);
    }
    public function execute()
    {
        echo "HE444444111222233333";
        try {
//            $this->connection->createTable('practice_test')

//            $this->connection->insert('practice_test', array("id" => 11, "description" => 'Some text'));
//            $table = $this->connection
//                ->newTable('practice_test')
//                ->addColumn(
//                    'id',
//                    Table::TYPE_INTEGER,
//                    null,
//                    [
//                        'identity' => true,
//                        'unsigned' => true,
//                        'nullable' => false,
//                        'primary' => true
//                    ],
//                    'ID'
//                )->addColumn(
//                    'description',
//                    Table::TYPE_TEXT,
//                    null,
//                    ['nullable' => false, 'default' => ''],
//                    'Description'
//                )
//                ->setOption('type', 'InnoDB')
//                ->setOption('charset', 'utf8');
//            $this->connection->createTable($table);

            $this->logger->info('function practice_test');

            $select = $this->connection->select()->from('practice_test');
            $data = $this->connection->fetchAll($select);
            $this->logger->info('function practice_test 2');
            echo "<pre>";
            echo "SOME";
            print_r($data);

        } catch (\Exception $e) {
            $this->logger->critical($e);
        }
    }
}
