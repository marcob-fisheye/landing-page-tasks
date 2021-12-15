<?php declare(strict_types=1);

namespace Marco\LandingPages\ViewModel;

use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class FeaturedCategories implements ArgumentInterface
{
    protected CollectionFactory $categoryCollectionFactory;

    public function __construct (
        CollectionFactory $categoryCollectionFactory
    )
    {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    public function getCategories($level, $size, $sort, $order): Collection
    {
        /** @var $categoryCollection Collection */
        $categoryCollection = $this->categoryCollectionFactory->create();

        $categoryCollection->addAttributeToFilter(
            'level', $level
        )
        ->setPageSize($size)
        ->setOrder($sort, $order);

        return $categoryCollection;
    }
}
