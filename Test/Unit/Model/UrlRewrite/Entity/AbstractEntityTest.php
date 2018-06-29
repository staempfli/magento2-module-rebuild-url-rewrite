<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\RebuildUrlRewrite\Test\Unit\Model\UrlRewrite\Entity;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

abstract class AbstractEntityTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);
    }

    public function getUrlRewriteMock()
    {
        $urlRewrite = $this->getMockBuilder(\Staempfli\RebuildUrlRewrite\Model\UrlRewrite::class)
            ->disableOriginalConstructor()
            ->getMock();
        $urlRewrite->expects($this->once())->method('setStoreId')->willReturn($urlRewrite);
        $urlRewrite->expects($this->once())->method('setEntity')->willReturn($urlRewrite);
        $urlRewrite->expects($this->once())->method('setCollection')->willReturn($urlRewrite);
        $urlRewrite->expects($this->once())->method('setRewriteGenerator')->willReturn($urlRewrite);
        return $urlRewrite;
    }

    public function getUrlGeneratorMock(string $class)
    {
        $urlGenerator = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();
        $urlGenerator->expects($this->any())->method('generate')->willReturn([]);
        return $urlGenerator;
    }

    public function getCollectionMock(string $class, string $entity)
    {
        $flatState = $this->getMockBuilder(\Magento\Catalog\Model\Indexer\Product\Flat\State::class)
            ->disableOriginalConstructor()
            ->getMock();
        /**
         * @var $entity \Magento\Eav\Model\Entity\AbstractEntity
         */
        $entity = $this->getMockBuilder($entity)
            ->disableOriginalConstructor()
            ->getMock();

        $connection = $this->getMockBuilder(\Magento\Framework\DB\Adapter\AdapterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $collection = $this->getMockBuilder($class)
            ->setMethods([
                'clear',
                'setStoreId',
                'getStoreId',
                'getIterator',
                'getFlatState',
                'addAttributeToSelect',
                'addAttributeToFilter',
                'addFieldToSelect',
                'addStoreFilter',
                'getEntity',
                'getConnection'
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $collection->expects($this->any())->method('clear')->willReturn($collection);
        $collection->expects($this->any())->method('setStoreId')->willReturn($collection);
        $collection->expects($this->any())->method('addAttributeToSelect')->willReturn($collection);
        $collection->expects($this->any())->method('addAttributeToFilter')->willReturn($collection);
        $collection->expects($this->any())->method('addFieldToSelect')->willReturn($collection);
        $collection->expects($this->any())->method('addStoreFilter')->willReturn($collection);
        $collection->expects($this->any())->method('getStoreId')->willReturn(1);
        $collection->expects($this->any())->method('getFlatState')->willReturn($flatState);
        $collection->expects($this->any())->method('getEntity')->willReturn($entity);
        $collection->expects($this->any())->method('getConnection')->willReturn($connection);

        $collectionItems = [
            $entity,
            $entity,
            $entity,
        ];

        $collection->expects($this->any())->method('getIterator')->willReturn(new \ArrayIterator($collectionItems));
        return $collection;
    }
}
