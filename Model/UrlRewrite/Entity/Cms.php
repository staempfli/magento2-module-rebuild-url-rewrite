<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\RebuildUrlRewrite\Model\UrlRewrite\Entity;

use Magento\Cms\Model\ResourceModel\Page\Collection as CmsPageCollection;
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
    /**
     * @var CmsPageCollection
     */
    private $cmsCollection;

    public function __construct(
        UrlRewriteInterface $urlRewrite,
        CmsPageUrlRewriteGenerator $cmsPageUrlRewriteGenerator,
        CmsPageCollection $cmsCollection
    ) {
        $this->urlRewrite = $urlRewrite;
        $this->cmsPageUrlRewriteGenerator = $cmsPageUrlRewriteGenerator;
        $this->cmsCollection = $cmsCollection;
    }

    public function rebuild(int $storeId, array $arguments = [])
    {
        $this->cmsCollection
            ->addStoreFilter($storeId)
            ->addFieldToSelect(['identifier']);

        $this->urlRewrite
            ->setStoreId($storeId)
            ->setEntity(CmsPageUrlRewriteGenerator::ENTITY_TYPE)
            ->setRewriteGenerator($this->cmsPageUrlRewriteGenerator)
            ->setCollection($this->cmsCollection)
            ->rebuild();
    }
}
