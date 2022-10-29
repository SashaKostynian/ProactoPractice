<?php
namespace Practice\PracticePatterns\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Filesystem;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class WriterCSV implements ObserverInterface
{
    private $logger;
    private $directory;

    public function __construct (
        LoggerInterface $logger,
        Filesystem $filesystem
    ) {
        $this->logger = $logger;
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
    }

    public function execute(Observer $observer)
    {
        $this->logger->info('OBSERVER IS WORKING');
        $this->logger->info($observer->getEvent()->getData('customer'));
        $this->logger->info($observer->getEvent()->getData('time'));

        $filepath = 'export/customerlist.csv';
        $this->directory->create('export');
        $stream = $this->directory->openFile($filepath, 'w+');
        $header = ['Email', 'time'];
        $stream->writeCsv($header);
        $data = [];
        $data[] = $observer->getEvent()->getData('customer');
        $data[] = $observer->getEvent()->getData('time');
        $stream->writeCsv($data);
        unset($data);
    }
}
