<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\RebuildUrlRewrite\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\RebuildUrlRewrite\Model\UrlRewrite;

final class UrlRewriteTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var UrlRewrite
     */
    private $urlRewrite;
    /**
     * @var \Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator
     */
    private $urlRewriteGenerator;
    /**
     * @var \Magento\Framework\Data\Collection
     */
    private $collection;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);

        $urlPersist = $this->getMockBuilder(\Magento\UrlRewrite\Model\UrlPersistInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlRewriteGenerator = $this->getMockBuilder(\Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->urlRewriteGenerator->expects($this->any())->method('generate')->willReturn([]);

        $this->collection = $this->getMockBuilder(\Magento\Framework\Data\Collection::class)
            ->setMethods(['getItems', 'getIterator'])
            ->disableOriginalConstructor()
            ->getMock();
        $collectionItems = [
            new \Magento\Framework\DataObject(
                ['id' => 1]
            ),
            new \Magento\Framework\DataObject(
                ['id' => 2]
            ),
            new \Magento\Framework\DataObject(
                ['id' => 3]
            ),
        ];

        $this->collection->expects($this->any())->method('getIterator')->willReturn(new \ArrayIterator($collectionItems));

        $this->urlRewrite = $objectManager->getObject(
            UrlRewrite::class,
            [
                'urlPersistInterface' => $urlPersist
            ]
        );
    }

    public function testSetStore()
    {
        $result = $this->urlRewrite->setStoreId(1);
        $this->assertInstanceOf(UrlRewrite::class, $result);
    }

    public function testSetEntity()
    {
        $result = $this->urlRewrite->setEntity('category');
        $this->assertInstanceOf(UrlRewrite::class, $result);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testSetRewriteGeneratorWithInvalidData($data)
    {
        $this->expectException(\LogicException::class);
        $this->urlRewrite->setRewriteGenerator($data);
    }

    public function testSetRewriteGenerator()
    {
        $result = $this->urlRewrite->setRewriteGenerator($this->urlRewriteGenerator);
        $this->assertInstanceOf(UrlRewrite::class, $result);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testSetCollectionWithInvalidData($data)
    {
        $this->expectException(\TypeError::class);
        $this->urlRewrite->setCollection($data);
    }

    public function testSetCollection()
    {
        $result = $this->urlRewrite->setCollection($this->collection);
        $this->assertInstanceOf(UrlRewrite::class, $result);
    }

    public function testRebuild()
    {
        $this->urlRewrite
            ->setStoreId(1)
            ->setEntity('category')
            ->setCollection($this->collection)
            ->setRewriteGenerator($this->urlRewriteGenerator)
            ->rebuild();
        $this->assertTrue(true);
    }

    public function testRebuildFailedBecauseNoEntityIsSet()
    {
        $this->urlRewrite->setCollection($this->collection)->setRewriteGenerator($this->urlRewriteGenerator)->rebuild();
        $this->assertTrue(true);
    }

    public function testRebuildFailedBecauseNoStoreIsSet()
    {
        $this->urlRewrite->setEntity('category')->setCollection($this->collection)->rebuild();
        $this->assertTrue(true);
    }

    public function testRebuildFailedBecauseNoUrlGeneratorIsSet()
    {
        $this->urlRewrite->setEntity('category')->setStoreId(1)->setCollection($this->collection)->rebuild();
        $this->assertTrue(true);
    }

    public function testRebuildFailedBecauseNoCollectionIsSet()
    {
        $this->expectException(\LogicException::class);
        $this->urlRewrite->rebuild();
        $this->assertTrue(true);
    }

    public function invalidDataProvider()
    {
        return [
            [1],
            [''],
            [[]],
            [new \stdClass()]
        ];
    }
}
