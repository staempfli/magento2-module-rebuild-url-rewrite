<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\RebuildUrlRewrite\Test\Unit\Console\Command;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\RebuildUrlRewrite\Console\Command\RebuildCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Magento\Framework\Console\Cli;

final class RebuildCommandTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var RebuildCommand
     */
    private $command;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);

        $appState = $this->getMockBuilder(\Magento\Framework\App\State::class)
            ->disableOriginalConstructor()
            ->getMock();

        $store = $this->getMockBuilder(\Magento\Store\Model\Store::class)
            ->disableOriginalConstructor()
            ->getMock();

        $storeRepositoryInterface = $this->getMockBuilder(\Magento\Store\Api\StoreRepositoryInterface::class)
            ->setMethods(['getList'])
            ->getMockForAbstractClass();
        $storeRepositoryInterface
            ->expects($this->any())
            ->method('getList')
            ->willReturn([]);

        $productFactory = $this->getMockBuilder(\Staempfli\RebuildUrlRewrite\Model\UrlRewrite\Entity\ProductFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $categoryFactory = $this->getMockBuilder(\Staempfli\RebuildUrlRewrite\Model\UrlRewrite\Entity\CategoryFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $cmsFactory = $this->getMockBuilder(\Staempfli\RebuildUrlRewrite\Model\UrlRewrite\Entity\CmsFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->command = $objectManager->getObject(
            RebuildCommand::class,
            [
                'appState' => $appState,
                'storeRepositoryInterface' => $storeRepositoryInterface,
                'productFactory' => $productFactory,
                'categoryFactory' => $categoryFactory,
                'cmsFactory' => $cmsFactory
            ]
        );
    }

    public function testExecute()
    {
        $tester = new CommandTester($this->command);
        $this->assertEquals(Cli::RETURN_SUCCESS, $tester->execute(['entities' => 'categories,products,cms-pages']));
    }
}
