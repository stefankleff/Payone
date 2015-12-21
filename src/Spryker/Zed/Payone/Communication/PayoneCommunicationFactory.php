<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace Spryker\Zed\Payone\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Payone\Dependency\Facade\PayoneToOmsInterface;
use Spryker\Zed\Payone\Dependency\Facade\PayoneToRefundInterface;
use Spryker\Zed\Payone\PayoneConfig;
use Spryker\Zed\Payone\PayoneDependencyProvider;
use Spryker\Zed\Payone\Persistence\PayoneQueryContainerInterface;
use Spryker\Zed\Refund\Business\RefundFacade;

/**
 * @method PayoneConfig getConfig()
 * @method PayoneQueryContainerInterface getQueryContainer()
 */
class PayoneCommunicationFactory extends AbstractCommunicationFactory
{

    /**
     * @return PayoneToOmsInterface
     */
    public function createOmsFacade()
    {
        return $this->getProvidedDependency(PayoneDependencyProvider::FACADE_OMS);
    }

    /**
     * @return PayoneToRefundInterface
     */
    public function createRefundFacade()
    {
        return $this->getProvidedDependency(PayoneDependencyProvider::FACADE_REFUND);
    }

}
