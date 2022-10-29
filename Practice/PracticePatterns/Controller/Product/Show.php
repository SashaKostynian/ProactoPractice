<?php

declare(strict_types=1);

namespace Practice\PracticePatterns\Controller\Product;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;

class Show extends Action
{
    private $resultPageFactory;
    private $customerSession;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Session $session
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $session;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        if ($this->customerSession->isLoggedIn()) {
            $resultPage->getConfig()->getTitle()->set(__('Products for logged customer (3)'));
        } else {
            $resultPage->getConfig()->getTitle()->set(__('Products for guest customer (6)'));
        }

        return $resultPage;
    }
}

