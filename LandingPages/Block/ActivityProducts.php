<?php declare(strict_types=1);

namespace Marco\LandingPages\Block;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Helper\Image;

class ActivityProducts extends Template
{
    protected CollectionFactory $collectionFactory;
    protected Image $imageHelper;

    public function __construct(
        CollectionFactory $collectionFactory,
        Image $imageHelper,
        Template\Context $context,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
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

    // public function getImageUrl()
    // {
    //     $image_url = $this->imageHelper->init($product, 'product_small_image')->getUrl();
    //     return $image_url;
    // }
}
