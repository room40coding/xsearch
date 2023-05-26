<?php

declare(strict_types=1);

namespace Amasty\Xsearch\Plugin\Elasticsearch5\Model\Adapter\FieldMapper;

use Amasty\Xsearch\Model\Indexer\ElasticSearchStockStatusStructureMapper;

class ProductFieldMapperProxyPlugin
{
    /**
     * @var ElasticSearchStockStatusStructureMapper
     */
    private $mapper;

    public function __construct(ElasticSearchStockStatusStructureMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param mixed $subject
     * @param array $result
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetAllAttributesTypes($subject, array $result): array
    {
        $fields = $this->mapper->buildEntityFields();

        return array_merge($result, $fields);
    }
}
