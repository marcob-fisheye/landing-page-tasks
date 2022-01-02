<?php declare(strict_types=1);

namespace Marco\LandingPages\ViewModel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductViewModel implements ArgumentInterface
{
    protected ProductRepositoryInterface $productRepository;
    protected PriceCurrencyInterface $priceCurrency;
    protected Image $imageHelper;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface $priceCurrency,
        Image $imageHelper
    ) {
        $this->productRepository = $productRepository;
        $this->priceCurrency = $priceCurrency;
        $this->imageHelper = $imageHelper;
    }

    public function getProduct(int $id): ProductInterface
    {
        return $this->productRepository->getById($id);
    }

    /**
     * @return string
     */
    public function getCurrencyAndPrice(float $price)
    {
        return $this->priceCurrency->format($price, true, 2);
    }

    /**
     * @return string
     */
    public function getImageUrl(int $id)
    {
        $product = $this->productRepository->getById($id);
        return $this->imageHelper->init($product, 'product_small_image')->getUrl();
    }
}
