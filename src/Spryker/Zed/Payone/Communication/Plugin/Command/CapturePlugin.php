<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Payone\Communication\Plugin\Command;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Command\CommandByOrderInterface;
use Spryker\Zed\Payone\Business\PayoneFacade;
use Orm\Zed\Payone\Persistence\SpyPaymentPayone;
use Spryker\Zed\Payone\Communication\PayoneCommunicationFactory;
use Orm\Zed\Sales\Persistence\SpySalesOrder;

/**
 * @method PayoneCommunicationFactory getCommunicationFactory()
 * @method PayoneFacade getFacade()
 */
class CapturePlugin extends AbstractPlugin implements CommandByOrderInterface
{

    /**
     * @param array $orderItems
     * @param SpySalesOrder $orderEntity
     * @param ReadOnlyArrayObject $data
     *
     * @return array $returnArray
     */
    public function run(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data)
    {
        /** @var SpyPaymentPayone $paymentEntity */
        $paymentEntity = $orderEntity->getSpyPaymentPayones()->getFirst();
        $this->getFacade()->capturePayment($paymentEntity->getFkSalesOrder());

        return [];
    }

}
