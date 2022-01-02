<?php declare(strict_types=1);

namespace Marco\LandingPages\Controller\Hero;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page as PageResult;

class Layout implements HttpGetActionInterface
{
    private ResultFactory $resultFactory;

    public function __construct(
        ResultFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
    }

    public function execute(): PageResult
    {
        /** @var PageResult $pageResult */
        $pageResult = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $pageResult->getConfig()->getTitle()->set(__('Hero Page: Custom Layout.'));
        return $pageResult;
    }
}
