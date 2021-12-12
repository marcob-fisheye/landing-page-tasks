<?php declare(strict_types=1);

namespace Marco\LandingPages\ViewModel;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ActivityProducts implements ArgumentInterface
{
    protected CollectionFactory $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    public function getProducts(): Collection
    {
        /** @var $products Collection */
        $products = $this->collectionFactory->create();

        $products->addAttributeToFilter(
                'price',
                ['gt' => 50]
            )
            ->addAttributeToFilter(
                'type_id',
                ['eq' => 'simple']
            )
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('color')
            ->addAttributeToSelect('description')
            ->setOrder('price', 'asc');

        $products->setPageSize(5);
        $products->setPage(2, 5);

        return $products;
    }
}
