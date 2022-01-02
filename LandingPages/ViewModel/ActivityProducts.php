<?php declare(strict_types=1);

namespace Marco\LandingPages\ViewModel;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ActivityProducts implements ArgumentInterface
{
    protected CollectionFactory $collectionFactory;
    protected ProductRepositoryInterface $productRepository;
    protected PriceCurrencyInterface $priceCurrency;
    protected Image $imageHelper;
    protected Http $httpRequest;

    public function __construct(
        CollectionFactory $collectionFactory,
        ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface $priceCurrency,
        Image $imageHelper,
        Http $httpRequest
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->productRepository = $productRepository;
        $this->priceCurrency = $priceCurrency;
        $this->imageHelper = $imageHelper;
        $this->httpRequest = $httpRequest;
    }

    public function getProducts(): Collection
    {
        /** @var $parameterValue int */
        $parameterValue = $this->httpRequest->getParam('activity_id');
        
        /** @var $products Collection */
        $products = $this->collectionFactory->create();

        if ($parameterValue) {
            $products->addAttributeToFilter(
                'activity', ['finset' => $parameterValue]
            );
        } else {
            $products->addAttributeToFilter(
                'activity', ['notnull' => true]
            );
        }

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
