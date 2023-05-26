<?php

declare(strict_types=1);

namespace Amasty\Xsearch\Plugin\Search\Model\Query;

use Magento\Search\Model\Query;

class KeepQueryText
{
    public function afterLoadByQueryText(Query $subject, Query $result, string $queryText): Query
    {
        $result->setQueryText($queryText);
        return $result;
    }
}
