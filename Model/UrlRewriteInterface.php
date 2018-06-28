<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\RebuildUrlRewrite\Model;

interface UrlRewriteInterface
{
    /**
     * @param int $storeId
     * @return mixed
     */
    public function setStoreId(int $storeId);

    /**
     * @param string $entity
     * @return $this
     */
    public function setEntity(string $entity);

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection|Magento\Cms\Model\ResourceModel\Page\Collection $collection
     * @return $this
     */
    public function setCollection($collection);

    /**
     * @param $rewriteGenerator
     * @return mixed
     */
    public function setRewriteGenerator($rewriteGenerator);

    /**
     * @return void
     */
    public function rebuild();
}
