<?php

declare(strict_types=1);

namespace Amasty\Xsearch\Model\System\Config\Source;

use Amasty\Xsearch\Model\ResourceModel\Cms\Block\FetchBlockTitles;
use Magento\Framework\Option\ArrayInterface;

class EmptyResultBlock implements ArrayInterface
{
    const DISABLED = 0;

    /**
     * @var FetchBlockTitles
     */
    private $fetchBlockTitles;

    public function __construct(FetchBlockTitles $fetchBlockTitles)
    {
        $this->fetchBlockTitles = $fetchBlockTitles;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [
            self::DISABLED => __('No'),
        ];

        return $options + $this->getBlocks();
    }

    private function getBlocks(): array
    {
        return $this->fetchBlockTitles->execute();
    }
}
