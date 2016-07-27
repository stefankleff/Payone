<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Dependency\Injector;

use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Shared\Kernel\ContainerInterface;
use Spryker\Shared\Kernel\Dependency\Injector\DependencyInjectorInterface;
use Spryker\Yves\Checkout\CheckoutDependencyProvider;
use Spryker\Yves\Payone\Plugin\PayoneCreditCardSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneDirectDebitSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneEPSOnlineTransferSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneEWalletSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneGiropayOnlineTransferSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneHandlerPlugin;
use Spryker\Yves\Payone\Plugin\PayoneIdealOnlineTransferSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneInstantOnlineTransferSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayonePostfinanceCardOnlineTransferSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayonePostfinanceEfinanceOnlineTransferSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayonePrzelewy24OnlineTransferSubFormPlugin;
use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginCollection;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection;

/**
 * @method \Spryker\Yves\Payone\PayoneFactory getFactory()
 */
class CheckoutDependencyInjector implements DependencyInjectorInterface
{

    /**
     * @param \Spryker\Shared\Kernel\ContainerInterface|\Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Shared\Kernel\ContainerInterface|\Spryker\Yves\Kernel\Container
     */
    public function inject(ContainerInterface $container)
    {
        $container->extend(CheckoutDependencyProvider::PAYMENT_SUB_FORMS, function (SubFormPluginCollection $paymentSubForms) {
            $paymentSubForms->add(new PayoneCreditCardSubFormPlugin());
            $paymentSubForms->add(new PayoneEWalletSubFormPlugin());
            $paymentSubForms->add(new PayoneDirectDebitSubFormPlugin());

            $paymentSubForms->add(new PayoneInstantOnlineTransferSubFormPlugin());
            $paymentSubForms->add(new PayoneGiropayOnlineTransferSubFormPlugin());
            $paymentSubForms->add(new PayoneEPSOnlineTransferSubFormPlugin());
            $paymentSubForms->add(new PayoneIdealOnlineTransferSubFormPlugin());
            $paymentSubForms->add(new PayonePostfinanceEfinanceOnlineTransferSubFormPlugin());
            $paymentSubForms->add(new PayonePostfinanceCardOnlineTransferSubFormPlugin());
            $paymentSubForms->add(new PayonePrzelewy24OnlineTransferSubFormPlugin());

            return $paymentSubForms;
        });

        $container->extend(CheckoutDependencyProvider::PAYMENT_METHOD_HANDLER, function (StepHandlerPluginCollection $paymentMethodHandler) {
            $payoneHandlerPlugin = new PayoneHandlerPlugin();

            $paymentMethodHandler->add($payoneHandlerPlugin, PaymentTransfer::PAYONE_CREDIT_CARD);
            $paymentMethodHandler->add($payoneHandlerPlugin, PaymentTransfer::PAYONE_E_WALLET);
            $paymentMethodHandler->add($payoneHandlerPlugin, PaymentTransfer::PAYONE_DIRECT_DEBIT);
            $paymentMethodHandler->add($payoneHandlerPlugin, PaymentTransfer::PAYONE_EPS_ONLINE_TRANSFER);
            $paymentMethodHandler->add($payoneHandlerPlugin, PaymentTransfer::PAYONE_GIROPAY_ONLINE_TRANSFER);
            $paymentMethodHandler->add($payoneHandlerPlugin, PaymentTransfer::PAYONE_INSTANT_ONLINE_TRANSFER);
            $paymentMethodHandler->add($payoneHandlerPlugin, PaymentTransfer::PAYONE_IDEAL_ONLINE_TRANSFER);
            $paymentMethodHandler->add($payoneHandlerPlugin, PaymentTransfer::PAYONE_POSTFINANCE_EFINANCE_ONLINE_TRANSFER);
            $paymentMethodHandler->add($payoneHandlerPlugin, PaymentTransfer::PAYONE_POSTFINANCE_CARD_ONLINE_TRANSFER);
            $paymentMethodHandler->add($payoneHandlerPlugin, PaymentTransfer::PAYONE_PRZELEWY24_ONLINE_TRANSFER);

            return $paymentMethodHandler;
        });

        return $container;
    }

}
