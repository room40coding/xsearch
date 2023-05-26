<?php

declare(strict_types=1);

namespace Amasty\Xsearch\Model\Analytics\DataCollectors;

interface AnalyticsDataCollectorInterface
{
    /**
     * The method must return an array of identifiers
     * that can be processed by the data collector
     *
     * @return string[]
     */
    public function getIdentifiers(): array;

    public function collect(array $data): void;
}
