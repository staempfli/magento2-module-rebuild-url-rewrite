<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\RebuildUrlRewrite\Model\UrlRewrite\Entity;

use Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator;
use Staempfli\RebuildUrlRewrite\Model\UrlRewrite\UrlRewriteEntityInterface;
use Staempfli\RebuildUrlRewrite\Model\UrlRewriteInterface;
use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;

class Category implements UrlRewriteEntityInterface
{
    /**
     * @var UrlRewriteInterface
     */
    private $urlRewrite;
    /**
     * @var CategoryUrlRewriteGenerator
     */
    private $categoryUrlRewriteGenerator;
    private $categoryCollection;

    public function __construct(
        UrlRewriteInterface $urlRewrite,
        CategoryUrlRewriteGenerator $categoryUrlRewriteGenerator,
        CategoryCollection $categoryCollection
    ) {
        $this->urlRewrite = $urlRewrite;
        $this->categoryUrlRewriteGenerator = $categoryUrlRewriteGenerator;
        $this->categoryCollection = $categoryCollection;
    }

    public function rebuild(int $storeId, array $arguments = [])
    {
        $this->categoryCollection->clear();
        $this->categoryCollection->setStoreId($storeId)
            ->addAttributeToSelect(['url_path', 'url_key'])
            ->addAttributeToFilter('level', array('gt' => 1));

        if ($arguments) {
            $this->categoryCollection->addFieldToFilter('entity_id', ['in' => $arguments]);
        }

        $this->urlRewrite
            ->setStoreId($storeId)
            ->setEntity(CategoryUrlRewriteGenerator::ENTITY_TYPE)
            ->setRewriteGenerator($this->categoryUrlRewriteGenerator)
            ->setCollection($this->categoryCollection)
            ->rebuild();
    }
}
