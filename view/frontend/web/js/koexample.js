define(['jquery','uiComponent','Magento_Customer/js/customer-data'], function($, Component, customerData) {
    'use strict'; 
        return Component.extend({
            initialize: function () {
                this._super();
                this.freeShipping = '';
				this.isVisible = customerData.get('cart')()['isFreeShipping'];
				console.log(this.isVisible)
            },
            getFreeShipping: function () {
            	if (this.isVisible) {
					return this.freeShipping = customerData.get('cart')()['freeShippingMethod'];
            	}
            }
        });
});