/**
 * Copyright (c) 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

'use strict';

function init(config) {
    var $form = $(config.formSelector);

    $form.submit(function(ev) {
        ev.preventDefault();

        window.processPayoneResponse = function(response) {
            console.log(response);
            if (response.status == 'VALID') {
                $form.find(config.cardpanInput).val('');
                $form.find(config.cardcvc2Input).val('');
                $form.find(config.pseudocardpanInput).val(response.pseudocardpan);
                $form.unbind('submit').submit();
            }
            else {
                alert(response.customermessage);
            }
        };

        if ($(config.currentPaymentMethodSelector).val() === 'payoneCreditCard') {
            var clientApiConfig = JSON.parse($form.find(config.clientApiConfigInput).val());
            var data = $.extend({}, clientApiConfig, {
                cardcvc2 : $form.find(config.cardcvc2Input).val(),
                cardexpiremonth : $form.find(config.cardexpiremonthInput).val(),
                cardexpireyear : $form.find(config.cardexpireyearInput).val(),
                cardholder : $form.find(config.cardholderInput).val(),
                cardpan : $form.find(config.cardpanInput).val(),
                cardtype : $form.find(config.cardtypeInput).val()
            });

            var options = {
                return_type : 'json',
                callback_function_name : 'processPayoneResponse'
            };

            var request = new PayoneRequest(data, options);
            request.checkAndStore();
        }
    });
}

module.exports = {
    init: init
};