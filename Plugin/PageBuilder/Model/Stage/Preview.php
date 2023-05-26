<?php

declare(strict_types=1);

namespace Amasty\Xsearch\Plugin\PageBuilder\Model\Stage;

use Magento\PageBuilder\Model\Stage\Preview as StagePreview;

class Preview
{
    /**
     * @param StagePreview $subject
     * @param \Closure $proceed
     *
     * @return bool
     */
    public function aroundIsPreviewMode($subject, \Closure $proceed)
    {
        try {
            return $proceed();
        } catch (\TypeError $e) {
            return false;
        }
    }
}
