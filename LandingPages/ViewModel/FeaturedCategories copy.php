<?php declare(strict_types=1);

namespace Marco\LandingPages\ViewModel;

use Magento\Catalog\Api\CategoryListInterface;
use Magento\Catalog\Api\Data\CategorySearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class FeaturedCategories implements ArgumentInterface
{
    protected CategoryListInterface $categoryList;
    protected SearchCriteriaBuilder $searchCriteriaBuilder;
    protected SortOrderBuilder $SortOrderBuilder;

    public function __construct(
        CategoryListInterface $categoryList,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $SortOrderBuilder
    ) {
        $this->categoryList = $categoryList;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $SortOrderBuilder;
    }

    /**
     * @param int $level
     * @param int $size
     * @param string $order
     */
    public function getCategories($level, $size, $order): CategorySearchResultsInterface
    {
        $this->searchCriteriaBuilder->addFilter('level', $level);
        $this->searchCriteriaBuilder->setPageSize($size);

        $sortOrder = $this->sortOrderBuilder
            ->setField($order)
            ->setDirection(SortOrder::SORT_ASC)
            ->create();
        $this->searchCriteriaBuilder->addSortOrder($sortOrder);

        $searchCriteria = $this->searchCriteriaBuilder->create();
       
        return $this->categoryList->getList($searchCriteria);
    }
}
