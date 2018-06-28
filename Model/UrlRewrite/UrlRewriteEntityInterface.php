<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\RebuildUrlRewrite\Model\UrlRewrite;

interface UrlRewriteEntityInterface
{
    /**
     * @param int $storeId
     * @return mixed
     */
    public function rebuild(int $storeId, array $arguments = []);
}
