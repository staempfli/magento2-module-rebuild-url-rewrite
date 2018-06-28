<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\RebuildUrlRewrite\Model\UrlRewrite\Entity;

use Magento\CmsUrlRewrite\Model\CmsPageUrlRewriteGenerator;
use Staempfli\RebuildUrlRewrite\Model\UrlRewrite\UrlRewriteEntityInterface;
use Staempfli\RebuildUrlRewrite\Model\UrlRewriteInterface;

class Cms implements UrlRewriteEntityInterface
{
    /**
     * @var UrlRewriteInterface
     */
    private $urlRewrite;
    /**
     * @var CmsPageUrlRewriteGenerator
     */
    private $cmsPageUrlRewriteGenerator;

    public function __construct(
        UrlRewriteInterface $urlRewrite,
        CmsPageUrlRewriteGenerator $cmsPageUrlRewriteGenerator
    ) {
        $this->urlRewrite = $urlRewrite;
        $this->cmsPageUrlRewriteGenerator = $cmsPageUrlRewriteGenerator;
    }

    public function rebuild(int $storeId)
    {
    }
}
