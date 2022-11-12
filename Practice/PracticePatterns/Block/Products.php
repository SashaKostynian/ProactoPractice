<?php

declare(strict_types=1);

namespace Practice\PracticePatterns\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Product\Collection\Proxy;

class Products  extends Template
{
    private $productCollectionFactory;
    private $customerSession;
    private $eventManager;
    private $proxyCollection;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Session $session,
        Proxy $proxyCollection,
        ManagerInterface $eventManager,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->customerSession = $session;
        $this->eventManager = $eventManager;
        $this->proxyCollection = $proxyCollection;
        parent::__construct($context, $data);
    }

    public function getProductCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        if ($this->customerSession->isLoggedIn()) {
            $collection->setPageSize(3);
        } else {
            $collection->setPageSize(1);
        }
        return $collection;
    }

//    public function getProductProxyCollection()
//    {
//        $collection = $this->proxyCollection->addAttributeToSelect('*');
//        $collection->setPageSize(10);
//        return $collection;
//    }

}
