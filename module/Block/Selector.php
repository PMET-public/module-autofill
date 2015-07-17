<?php

namespace MagentoEse\AutoFill\Block;

/**
 * Auto Fill Selector block
 */
class Selector extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(\Magento\Framework\View\Element\Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }
}
