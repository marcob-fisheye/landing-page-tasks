<?php declare(strict_types=1);

namespace Marco\LandingPages\ViewModel;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Category as ResourceCategory;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class FeaturedCategories implements ArgumentInterface
{
    protected CategoryFactory $categoryFactory;
    protected ResourceCategory $resourceCategory;

    public function __construct (
        CategoryFactory $categoryFactory,
        ResourceCategory $resourceCategory
    )
    {
        $this->categoryFactory = $categoryFactory;
        $this->resourceCategory = $resourceCategory;
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
}
