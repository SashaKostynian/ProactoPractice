<?php

declare(strict_types=1);

namespace Practice\PracticePatterns\Controller\Ajax;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\View\Result\PageFactory;

class Button extends Action
{
    private $resultPageFactory;
    private $customerSession;
    private $eventManager;

    public function __construct(
        Context $context,
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
