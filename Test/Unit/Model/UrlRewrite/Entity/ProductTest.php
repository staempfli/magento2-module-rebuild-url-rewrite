<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\RebuildUrlRewrite\Test\Unit\Model\UrlRewrite\Entity;

use Staempfli\RebuildUrlRewrite\Model\UrlRewrite\Entity\Product;

final class ProductTest extends AbstractEntityTest
{
    /**
     * @var Product
     */
    private $model;

    public function setUp()
    {
        parent::setUp();

        $this->model = $this->objectManager->getObject(
            Product::class,
            [
                'urlRewrite' => $this->getUrlRewriteMock(),
                'urlGenerator' => $this->getUrlGeneratorMock(\Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator::class),
                'productCollection' => $this->getCollectionMock(\Magento\Catalog\Model\ResourceModel\Product\Collection::class, \Magento\Catalog\Model\Product::class)
            ]
        );
    }

    public function testProductRebuild()
    {
        $this->model->rebuild(1);
    }
}
