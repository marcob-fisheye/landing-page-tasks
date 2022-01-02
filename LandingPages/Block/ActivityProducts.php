<?php declare(strict_types=1);

namespace Marco\LandingPages\Block;

use Magento\Catalog\Model\Product\Attribute\Repository;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Template;

class ActivityProducts extends Template
{
    protected Repository $attributeRepository;
    protected CollectionFactory $collectionFactory;
    protected ProductRepositoryInterface $productRepository;
    protected PriceCurrencyInterface $priceCurrency;
    protected Image $imageHelper;

    public function __construct(
        Repository $attributeRepository,
        CollectionFactory $collectionFactory,
        ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface $priceCurrency,
        Image $imageHelper,
        Template\Context $context,
        array $data = []
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->collectionFactory = $collectionFactory;
        $this->productRepository = $productRepository;
        $this->priceCurrency = $priceCurrency;
        $this->imageHelper = $imageHelper;
        parent::__construct($context, $data);
    }

    /**
     * Get attributes and return activity attribute id
     *
     * @return int
     */
    public function getOptionId(string $attributeName, string $optionText)
    {
        $attribute = $this->attributeRepository->get($attributeName);
        $optionId = $attribute->getSource()->getOptionId($optionText);
        
        return $optionId;
    }
    
    public function getProducts(string $attributeName, string $optionText): Collection
    {
        /** @var $products Collection */
        $products = $this->collectionFactory->create();

        $optionId = $this->getOptionId($attributeName, $optionText);

        $products->addAttributeToFilter(
            'status', 1
        )
        ->addAttributeToFilter(
            'visibility', 4
        )
        ->addAttributeToFilter(
            $attributeName, ['finset' => $optionId]
        )
        ->addAttributeToSelect('price')
        ->addAttributeToSelect('small_image');

        $products->setPageSize(12)->setOrder('name', 'asc');

        return $products;
    }

    /**
     * @param float $price
     * @return string
     */
    public function getCurrencyAndPrice($price)
    {
        return $this->priceCurrency->format($price, true, 2);
    }

    /**
     * @param int $id
     * @return string
     */
    public function getImageUrl($id)
    {
        $product = $this->productRepository->getById($id);
        return $this->imageHelper->init($product, 'product_small_image')->getUrl();
    }
}
