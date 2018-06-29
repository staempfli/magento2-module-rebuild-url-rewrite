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
     * @param \Magento\Framework\Data\Collection $collection
     * @return $this
     */
    public function setCollection(\Magento\Framework\Data\Collection $collection);

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
