<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Communication\Plugin\Oms\Command;

use Generated\Shared\Transfer\PayoneCaptureTransfer;
use Generated\Shared\Transfer\PayonePaymentTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Command\CommandByOrderInterface;

/**
 * @method \Spryker\Zed\Payone\Communication\PayoneCommunicationFactory getFactory()
 * @method \Spryker\Zed\Payone\Business\PayoneFacade getFacade()
 */
class CapturePlugin extends AbstractPayonePlugin implements CommandByOrderInterface
{

    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return array $returnArray
     */
    public function run(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data)
    {
        $captureTransfer = new PayoneCaptureTransfer();

        /** @var \Orm\Zed\Payone\Persistence\SpyPaymentPayone $paymentEntity */
        $paymentTransfer = new PayonePaymentTransfer();
        $paymentTransfer->setFkSalesOrder($orderEntity->getSpyPaymentPayones()->getFirst()->getFkSalesOrder());
        $captureTransfer->setPayment($paymentTransfer);

        $orderTransfer = $this->getOrderTransfer($orderEntity);

        $captureTransfer->setAmount($orderTransfer->getTotals()->getGrandTotal());

        $this->getFacade()->capturePayment($captureTransfer);

        return [];
    }

}
