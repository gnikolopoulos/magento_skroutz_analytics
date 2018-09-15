<?php
/**
 * Skroutz Analytics module observer
 *
 * @category   ID
 * @package    ID_SkroutzAnalytics
 */
class ID_SkroutzAnalytics_Model_Observer
{
    /**
     * Add order information into SA block to render on checkout success pages
     *
     * @param Varien_Event_Observer $observer
     */
    public function setSkroutzAnalyticsOnOrderSuccessPageView(Varien_Event_Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $block = Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('skroutz_analytics');
        if ($block) {
            $block->setOrderIds($orderIds);
        }
    }
}
