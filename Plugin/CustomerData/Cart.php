<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Convert\FreeShippingMethod\Plugin\CustomerData;

/**
 * Cart source
 */

class Cart
{

	/**
	 * @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
	 */
	private $scopeConfig;

	/**
	 * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
	 */
	public function __construct(
	    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
	) {
	    $this->scopeConfig = $scopeConfig;
	}
    /**
     * {@inheritdoc}
     */
    public function aroundGetSectionData(\Magento\Checkout\CustomerData\Cart $subject, \Closure $result)
    {
        // Get the previous data
        $data = $result();
        $minOrderAmount = 0;
        $minOrderAmount = (float)$this->scopeConfig->getValue('carriers/freeshipping/free_shipping_subtotal', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $isFreeShipping = $this->scopeConfig->getValue('carriers/freeshipping/active', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $subtotalAmount = (float)$data['subtotalAmount'];

        // Append variable
        if ($isFreeShipping) {
        	$data['isFreeShipping'] = 1;
			if($minOrderAmount != 0 && $minOrderAmount < $subtotalAmount){
	        	$data['freeShippingMethod'] = __("You're eligible for Free Shipping");
			}else{
				$data['freeShippingMethod'] = __("You're %1 away from Free Shipping", $minOrderAmount);
			}
        }else{
        	$data['isFreeShipping'] = 0;
        }

        return $data;
    }
	
}