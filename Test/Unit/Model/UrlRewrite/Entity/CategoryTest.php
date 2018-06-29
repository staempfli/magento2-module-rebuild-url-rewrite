<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\RebuildUrlRewrite\Test\Unit\Model\UrlRewrite\Entity;

use Staempfli\RebuildUrlRewrite\Model\UrlRewrite\Entity\Category;

final class CategoryTest extends AbstractEntityTest
{
    /**
     * @var Category
     */
    private $model;

    public function setUp()
    {
        parent::setUp();

        $this->model = $this->objectManager->getObject(
            Category::class,
            [
                'urlRewrite' => $this->getUrlRewriteMock(),
                'urlGenerator' => $this->getUrlGeneratorMock(\Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator::class),
                'productCollection' => $this->getCollectionMock(\Magento\Catalog\Model\ResourceModel\Category\Collection::class, \Magento\Catalog\Model\Category::class)
            ]
        );
    }

    public function testCategoryRebuild()
    {
        $this->model->rebuild(1);
    }
}
