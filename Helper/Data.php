<?php

namespace MagentoEse\AutoFill\Helper;

use Magento\Store\Model\Store;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Auto Fill module base helper
 */
class Data extends AbstractHelper
{
    /**
     * Config value that indicates if Auto Fill is enabled
     */
    const CONFIG_PATH_ENABLED = 'magentoese_autofill/general/enable_autofill';

    /**
     * Check if Auto Fill is enabled
     *
     * @return bool
     */
    public function isAutoFillEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::CONFIG_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
}
