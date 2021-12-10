<?php declare(strict_types=1);

namespace Marco\Interception\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CustomProductDataAddition implements ObserverInterface
{
    public function execute(Observer $observer): void 
    {
        $product = $observer->getEvent()->getData('product');

        $product->setData('custom_data', 'Our Custom Value');
        
        // dump($observer->getEvent()->getData('product'));
    }
}
