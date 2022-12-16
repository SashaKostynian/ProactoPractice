<?php
namespace Practice\CustomDB\Cron;

use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface;

class UpdateDB
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var AddressRepository
     */
    public $addressRepository;

    /**
     * @var StreetFactory
     */
    public $streetFactory;

    /**
     * @var WarehouseFactory
     */
    public $warehouseFactory;

    /**
     * @var AddressManagementInterface
     */
    public $addressManagement;

    /**
     * @var ResourceConnection
     */
    protected $_resourceConnecton;

    /**
     * UpdateDB constructor.
     * @param LoggerInterface $logger
     * @param AddressRepository $addressRepository
     * @param StreetFactory $streetFactory
     * @param WarehouseFactory $warehouseFactory
     * @param AddressManagementInterface $addressManagement
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        LoggerInterface $logger,
        AddressRepository $addressRepository,
        StreetFactory $streetFactory,
        WarehouseFactory $warehouseFactory,
        AddressManagementInterface $addressManagement,
        ResourceConnection $resourceConnection
    ) {
        $this->logger = $logger;
        $this->addressRepository = $addressRepository;
        $this->streetFactory = $streetFactory;
        $this->warehouseFactory = $warehouseFactory;
        $this->addressManagement = $addressManagement;
        $this->_resourceConnecton = $resourceConnection;
    }

    /**
     * @throws \Exception
     */
    public function execute()
    {
        $this->logger->info('NP DB update started');

        $connection = $this->_resourceConnecton->getConnection();
        $streetTable = $this->_resourceConnecton->getTableName('np_street');
        $connection->truncateTable(
            $streetTable
        );

        $warehouseTable = $this->_resourceConnecton->getTableName('np_warehouse');
        $connection->truncateTable(
            $warehouseTable
        );

        $warehouses = $_api->getWarehouses();
        if ($warehouses['data']) {
            foreach ($warehouses['data'] as $warehouse) {
                $warehouseData = [
                    "entity_id" => $connection->getAutoIncrementField($streetTable),
                    'ref' => $warehouse['Ref'],
                    'city_ref' => $warehouse['CityRef'],
                    'warehouse_key' => $warehouse['SiteKey'],
                    'description' => $warehouse['Description'],
                    'description_ru' => $warehouse['DescriptionRu'],
                    'type' => $warehouse['TypeOfWarehouse'],
                    'number' => $warehouse['Number'],
                    'short_address' => $warehouse['ShortAddress'],
                    'short_address_ru' => $warehouse['ShortAddressRu'],
                    'status' => $warehouse['WarehouseStatus'],
                    'bicycle_parking' => $warehouse['BicycleParking'],
                    'longitude' => $warehouse['Longitude'],
                    'latitude' => $warehouse['Latitude'],
                    'post_finance' => $warehouse['PostFinance'],
                    'pos_terminal' => $warehouse['POSTerminal'],
                    'international' => $warehouse['InternationalShipping'],
                    'max_weight' => $warehouse['TotalMaxWeightAllowed'],
                    'place_max_weight' => $warehouse['PlaceMaxWeightAllowed'],
                    'reception_schedule' => json_encode($warehouse['Reception']),
                    'delivery_schedule' => json_encode($warehouse['Delivery']),
                    'work_schedule' => json_encode($warehouse['Schedule']),
                    'site_key' => $warehouse['SiteKey']
                ];
                $connection->insertOnDuplicate($warehouseTable, $warehouseData);
            }
        }
        $this->logger->info('NP DB update finished');
    }
}
