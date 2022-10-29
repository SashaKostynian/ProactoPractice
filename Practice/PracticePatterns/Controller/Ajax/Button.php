<?php

declare(strict_types=1);

namespace Practice\PracticePatterns\Controller\Ajax;

use Magecom\NovaPoshta\Model\AddressRepository;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;

class Button extends \Magento\Framework\App\Action\Action
{
    private $resultPageFactory;
    private $customerSession;
    private $eventManager;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        PageFactory $resultPageFactory,
        Session $session,
        ManagerInterface $eventManager
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $session;
        $this->eventManager = $eventManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->eventManager->dispatch('practice_event_after', ['customer' => $this->customerSession->isLoggedIn() ?
            $this->customerSession->getCustomer()->getEmail() : "guest", 'time' => date("Y-m-d H:i:s", time())]);
    }
}
