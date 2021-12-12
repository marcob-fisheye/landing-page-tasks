<?php declare(strict_types=1);

namespace Marco\LandingPages\Block;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Category as ResourceCategory;
use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\View\Element\Template;

class FeaturedCategories extends Template
{
    protected CategoryFactory $categoryFactory;
    protected ResourceCategory $resourceCategory;
    protected CollectionFactory $categoryCollectionFactory;

    public function __construct (
        CategoryFactory $categoryFactory,
        ResourceCategory $resourceCategory,
        CollectionFactory $categoryCollectionFactory,
        Template\Context $context,
        array $data = []
    )
    {
        $this->categoryFactory = $categoryFactory;
        $this->resourceCategory = $resourceCategory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getCategory(int $id): Category
    {
        /** @var $category Category */
        $category = $this->categoryFactory->create();

        return $category;
    }

    public function getCategoryByResource(int $id): Category
    {
        /** @var $category Category */
        $category = $this->categoryFactory->create();
        $this->resourceCategory->load($category, $id);

        return $category;
    }

    public function getCategories($level, $sort, $order): Collection
    {
        /** @var $categoryCollection Collection */
        $categoryCollection = $this->categoryCollectionFactory->create();

        $categoryCollection->addAttributeToFilter(
            'level', $level
        )
        ->setOrder($sort, $order);

        return $categoryCollection;
    }
}
