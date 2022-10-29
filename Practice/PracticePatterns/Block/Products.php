<?php

declare(strict_types=1);

namespace Practice\PracticePatterns\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\View\Element\Template;

class Products  extends Template
{
    private $productCollectionFactory;
    private $customerSession;
    private $eventManager;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Session $session,
        ManagerInterface $eventManager,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->customerSession = $session;
        $this->eventManager = $eventManager;
        parent::__construct($context, $data);
    }

    public function getProductCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        if ($this->customerSession->isLoggedIn()) {
            $collection->setPageSize(3);
        } else {
            $collection->setPageSize(6);
        }
        return $collection;
    }

    public function buttonPress()
    {
//        $this->eventManager->dispatch('practice_event_after');

//        file_put_contents('test.txt', 3);

//        $this->eventManager->dispatch('practice_event_after', ['customer' => $this->customerSession->isLoggedIn() ?
//            $this->customerSession->getCustomer()->getEmail() : "guest", 'time' => date("Y-m-d H:i:s", time())]);

//        $this->eventManager->dispatch('custom_button_press', ['customer' => $this->customerSession->isLoggedIn() ?
//            $this->customerSession->getCustomer()->getEmail() : "guest", 'time' => date("Y-m-d", time())]);
    }
}
