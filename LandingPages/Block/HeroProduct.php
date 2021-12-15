<?php declare(strict_types=1);

namespace Marco\LandingPages\Block;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Template;

class HeroProduct extends Template
{
    protected ProductRepositoryInterface $productRepository;
    protected PriceCurrencyInterface $priceCurrency;
    protected StoreManagerInterface $storeManager;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface $priceCurrency,
        StoreManagerInterface $storeManager,
        Template\Context $context,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->priceCurrency = $priceCurrency;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @param int $id
     */
    public function getProduct($id): ProductInterface
    {
        $product = $this->productRepository->getById($id);
        return $product;
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
     * @return string
     */
    public function getMediaUrl()
    {
        $store = $this->storeManager->getStore();
        $mediaUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }
}
