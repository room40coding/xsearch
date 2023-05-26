<?php

declare(strict_types=1);

namespace Amasty\Xsearch\Model\Indexer;

use Amasty\Xsearch\Block\Search\AbstractSearch;
use Amasty\Xsearch\Helper\Data;
use Magento\Framework\Url;
use Magento\Store\Model\StoreManagerInterface as StoreManager;

class ElasticExternalProvider
{
    const FULLTEXT_INDEX_FIELD = 'fulltext_index';
    const BLOCK_TYPE_FIELD = 'block_type';

    /**
     * @var \Magento\Store\Model\App\Emulation
     */
    private $appEmulation;

    /**
     * @var array
     */
    private $sources;

    /**
     * @var Data
     */
    private $helper;

    /**
     * @var Url
     */
    private $urlBuilder;

    /**
     * @var StoreManager
     */
    private $storeManager;

    public function __construct(
        \Magento\Store\Model\App\Emulation $appEmulation,
        \Amasty\Xsearch\Block\Search\LandingFactory $landingFactory,
        \Amasty\Xsearch\Block\Search\CategoryFactory $categoryFactory,
        \Amasty\Xsearch\Block\Search\BrandFactory $brandFactory,
        \Amasty\Xsearch\Block\Search\PageFactory $pageFactory,
        \Amasty\Xsearch\Block\Search\BlogFactory $blogFactory,
        \Amasty\Xsearch\Block\Search\FaqFactory $faqFactory,
        Data $helper,
        Url $urlBuilder,
        StoreManager $storeManager,
        array $sources = []
    ) {
        $this->appEmulation = $appEmulation;
        $this->sources = array_merge(
            [
                $landingFactory,
                $categoryFactory,
                $brandFactory,
                $pageFactory,
                $blogFactory,
                $faqFactory
            ],
            $sources
        );
        $this->helper = $helper;
        $this->urlBuilder = $urlBuilder;
        $this->storeManager = $storeManager;
    }

    /**
     * @param int $storeId
     * @return array
     */
    public function get(int $storeId): array
    {
        $this->appEmulation->startEnvironmentEmulation($storeId, \Magento\Framework\App\Area::AREA_FRONTEND, true);
        $this->urlBuilder->setScope($this->storeManager->getStore());
        $result = [];
        foreach ($this->sources as $source) {
            $block = $source->create();
            /** @var AbstractSearch $block */
            if ($block instanceof AbstractSearch && $this->helper->isIndexEnable($block)) {
                $block->setLimit(0);
                $block->setIndexMode(true);
                $result = $this->setDocument($block, $result);
            }
        }

        $this->appEmulation->stopEnvironmentEmulation();

        return $result;
    }

    /**
     * @param $block
     * @param $result
     * @return array
     */
    private function setDocument($block, $result)
    {
        $documents = $block->getResults();
        if ($documents) {
            $fulltextValues = $block->getIndexFulltextValues();
            foreach ($documents as $id => &$document) {
                $document[self::BLOCK_TYPE_FIELD] = $block->getBlockType();
                $document[self::FULLTEXT_INDEX_FIELD] = $fulltextValues[$id];
                $result[] = $document;
            }
        }

        return $result;
    }
}
