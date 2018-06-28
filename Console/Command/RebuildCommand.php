<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\RebuildUrlRewrite\Console\Command;

use Magento\Framework\App\State;
use Magento\Store\Api\StoreRepositoryInterface;
use Staempfli\RebuildUrlRewrite\Model\UrlRewrite\Entity\ProductFactory;
use Staempfli\RebuildUrlRewrite\Model\UrlRewrite\Entity\CategoryFactory;
use Staempfli\RebuildUrlRewrite\Model\UrlRewrite\Entity\CmsFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class RebuildCommand extends Command
{
    const INPUT_STORES = 'stores';
    const INPUT_PRODUCTS = 'products';
    const INPUT_CAEGORIES = 'cagtegories';
    const INPUT_ENTITY = 'entities';

    /**
     * @var State
     */
    private $appState;
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;
    /**
     * @var ProductFactory
     */
    private $productFactory;
    /**
     * @var CategoryFactory
     */
    private $categoryFactory;
    /**
     * @var CmsFactory
     */
    private $cmsFactory;
    /**
     * @var InputInterface
     */
    private $input;

    public function __construct(
        State $appState,
        StoreRepositoryInterface $storeRepository,
        ProductFactory $productFactory,
        CategoryFactory $categoryFactory,
        CmsFactory $cmsFactory,
        $name = null
    ) {
        $this->appState = $appState;
        $this->storeRepository = $storeRepository;
        $this->productFactory = $productFactory;
        $this->categoryFactory = $categoryFactory;
        $this->cmsFactory = $cmsFactory;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('urlrewrite:rebuild')
            ->setDescription('Rebuild url rewrites of products and categories')
            ->setDefinition([
                new InputOption(
                    self::INPUT_STORES,
                    's',
                    InputArgument::OPTIONAL,
                    "Store ID's"
                ),
                new InputOption(
                    self::INPUT_PRODUCTS,
                    'p',
                    InputArgument::OPTIONAL,
                    "Product ID's"
                ),
                new InputOption(
                    self::INPUT_CAEGORIES,
                    'c',
                    InputArgument::OPTIONAL,
                    "Category ID's"
                ),
                new InputArgument(
                    self::INPUT_ENTITY,
                    InputArgument::REQUIRED,
                    "Available entities [categories,products,cms-pages]"
                ),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $stores = $this->getAllStoreIds();

        $argument = $this->getArgumentValue(self::INPUT_ENTITY);

        foreach ($stores as $storeId => $storeCode) {
            if ($argument && in_array('categories', $argument)) {
                $output->writeln(sprintf('Rebuild category urls for store: [%s]', $storeCode));
                $this->categoryFactory->create()->rebuild($storeId, $this->getOptionValue(self::INPUT_CAEGORIES));
            }

            if ($argument && in_array('products', $argument)) {
                $output->writeln(sprintf('Rebuild product urls for store: [%s]', $storeCode));
                $this->productFactory->create()->rebuild($storeId, $this->getOptionValue(self::INPUT_PRODUCTS));
            }

            if ($argument && in_array('cms-pages', $argument)) {
                $output->writeln(sprintf('Rebuild cms urls for store: [%s]', $storeCode));
                $this->cmsFactory->create()->rebuild($storeId);
            }
        }
    }

    /**
     * @return array
     */
    private function getAllStoreIds(): array
    {
        $data = [];
        $stores = $this->storeRepository->getList();
        $storeOptions = $this->getOptionValue(self::INPUT_STORES);

        try {
            $areaCode = $this->appState->getAreaCode();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->appState->setAreaCode('adminhtml');
        }

        foreach ($stores as $store) {
            if ((int)$store->getId() === 0 || !$store->isActive()) {
                continue;
            }
            if ($storeOptions && !in_array($store->getId(), $storeOptions)) {
                continue;
            }
            $data[(int)$store->getId()] = $store->getCode();
        }
        return $data;
    }

    /**
     * @param string $option
     * @return array
     */
    private function getOptionValue(string $option): array
    {
        $value = $this->input->getOption($option) ?? '';
        return $this->getFilteredValue($value);
    }

    /**
     * @param string $argument
     * @return array
     */
    private function getArgumentValue(string $argument) : array
    {
        $value = $this->input->getArgument($argument) ?? '';
        return $this->getFilteredValue($value);
    }

    /**
     * @param string $value
     * @return array
     */
    private function getFilteredValue(string $value)
    {
        return array_filter(explode(',', trim($value, '= ')));
    }
}
