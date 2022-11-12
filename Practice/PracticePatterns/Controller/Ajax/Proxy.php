<?php

declare(strict_types=1);

namespace Practice\PracticePatterns\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Catalog\Model\ResourceModel\Product\Collection\Proxy as ProxyCollection;
use Magento\Framework\Json\Helper\Data;

class Proxy extends Action
{
    private $proxyCollection;
    private $jsonHelper;

    public function __construct(
        Context $context,
        ProxyCollection $proxyCollection,
        Data $jsonHelper
    ) {
        $this->proxyCollection = $proxyCollection;
        $this->jsonHelper = $jsonHelper;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->proxyCollection->addAttributeToSelect('*');
        $collection->setPageSize(10);
        return $this->jsonResponse($collection);
    }

    public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }
}
