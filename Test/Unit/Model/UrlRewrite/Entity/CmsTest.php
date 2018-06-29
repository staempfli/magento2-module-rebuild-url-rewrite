<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\RebuildUrlRewrite\Test\Unit\Model\UrlRewrite\Entity;

use Staempfli\RebuildUrlRewrite\Model\UrlRewrite\Entity\Cms;

final class CmsTest extends AbstractEntityTest
{
    /**
     * @var Cms
     */
    private $model;

    public function setUp()
    {
        parent::setUp();

        $this->model = $this->objectManager->getObject(
            Cms::class,
            [
                'urlRewrite' => $this->getUrlRewriteMock(),
                'urlGenerator' => $this->getUrlGeneratorMock(\Magento\CmsUrlRewrite\Model\CmsPageUrlRewriteGenerator::class),
                'productCollection' => $this->getCollectionMock(\Magento\Cms\Model\ResourceModel\Page\Collection::class, \Magento\Cms\Model\Page::class)
            ]
        );
    }

    public function testCmsRebuild()
    {
        $this->model->rebuild(1);
    }
}
