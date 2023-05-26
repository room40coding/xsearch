<?php

namespace Amasty\Xsearch\Block\Adminhtml\System\Config\Form\Field;

class Blog extends AbstractField
{
    const MODULE_NAME = 'Amasty_Blog';
    const CONFIG_MODULE_NAME = 'blog';

    /**
     * @return \Magento\Framework\Phrase|string
     */
    protected function getNote()
    {
        return __('Allows to search by blog pages created with Amasty Blog extension.');
    }
}
