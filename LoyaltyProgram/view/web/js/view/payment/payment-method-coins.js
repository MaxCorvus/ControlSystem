define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (Component,
              rendererList) {
        'use strict';
        const isEnabled = window.checkoutConfig.payment.coins.enable;
        if (isEnabled) {
            rendererList.push(
                {
                    type: 'max_coins',
                    component: 'Max_LoyaltyProgram/js/view/payment/method-renderer/payment_method'
                }
            );
        }
        return Component.extend({});
    }

);