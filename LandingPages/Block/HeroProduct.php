<?php declare(strict_types=1);

namespace Marco\LandingPages\Block;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Helper\Image;

class HeroProduct extends Template
{
    protected ProductRepositoryInterface $productRepository;
    protected Image $imageHelper;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        Image $imageHelper,
        Template\Context $context,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
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

    // public function getImageUrl()
    // {
    //     $image_url = $this->imageHelper->init($product, 'product_small_image')->getUrl();
    //     return $image_url;
    // }
}
