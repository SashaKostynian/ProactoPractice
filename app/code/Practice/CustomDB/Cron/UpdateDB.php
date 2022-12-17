<?php
namespace Practice\CustomDB\Cron;

use Magento\Framework\App\ResourceConnection;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Psr\Log\LoggerInterface;

class UpdateDB
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ResourceConnection
     */
    private $resourceConnecton;

    /**
     * @var CollectionFactory
     */
    private $orderCollectionFactory;

    /**
     * UpdateDB constructor.
     * @param LoggerInterface $logger
     * @param ResourceConnection $resourceConnection
     * @param CollectionFactory $orderCollectionFactory
     */
    public function __construct(
        LoggerInterface $logger,
        ResourceConnection $resourceConnection,
        CollectionFactory $orderCollectionFactory
    ) {
        $this->logger = $logger;
        $this->resourceConnecton = $resourceConnection;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * @throws \Exception
     */
    public function execute()
    {
        $this->logger->info('Orders DB update started');

        $connection = $this->resourceConnecton->getConnection('custom');
        $orderTable = $connection->getTableName('order');

        $orders = $this->getOrderCollection();

        foreach ($orders as $order) {
            $connection->insertOnDuplicate($orderTable,
                [
                    'entity_id' => $connection->getAutoIncrementField('order'),
                    'customer_id' => $order->getData('customer_id'),
                    'address_id' => '22',
                    'delivery_method' => $order->getData('shipping_description'),
                    'delivery_price' => $order->getData('base_shipping_amount'),
                    'payment_method' => '22',
                    'total_price' => '22'
                ]
            );
        }

        $this->logger->info('Orders DB update finished');
    }

    public function getOrderCollection()
    {
        $to = strtotime('-1 hours', strtotime(date("Y-m-d h:i:s")));
        $from = strtotime('-2 hours', strtotime($to));
        $from = date('Y-m-d h:i:s', $from);

        $collection = $this->orderCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->addFieldToFilter('created_at',
                ['gteq' => $from]
            )
            ->addFieldToFilter('created_at',
                ['lteq' => $to]
            );

        return $collection;
    }

}
