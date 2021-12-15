<?php declare(strict_types=1);

namespace Marco\LandingPages\Block;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Template;

class ActivityProducts extends Template
{
    protected CollectionFactory $collectionFactory;
    protected ProductRepositoryInterface $productRepository;
    protected PriceCurrencyInterface $priceCurrency;
    protected Image $imageHelper;

    public function __construct(
        CollectionFactory $collectionFactory,
        ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface $priceCurrency,
        Image $imageHelper,
        Template\Context $context,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->productRepository = $productRepository;
        $this->priceCurrency = $priceCurrency;
        $this->imageHelper = $imageHelper;
        parent::__construct($context, $data);
    }

    public function getProducts(): Collection
    {
        /** @var $products Collection */
        $products = $this->collectionFactory->create();

        $products->addAttributeToFilter(
            'status', 1
        )
        ->addAttributeToFilter(
            'visibility', 4
        )
        ->addAttributeToFilter(
            'activity', ['notnull' => true]
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
