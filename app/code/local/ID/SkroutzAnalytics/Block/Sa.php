<?php
/**
 * Skroutz Analitics Page Block
 *
 * @category   ID
 * @package    ID_SkroutzAnalytics
 * @author     Interactive Design <info@interactive-design.gr>
 */
class ID_SkroutzAnalytics_Block_Sa extends Mage_Core_Block_Template
{
    /**
     * Render regular page tracking javascript code
     * @param string $storeId
     * @return string
     */
    protected function _getPageTrackingCode($storeId)
    {
        return "
ga('create', '{$this->jsQuoteEscape($storeId)}', 'auto');
ga('send', 'pageview');
";
    }

    /**
     * Render information about specified orders and their items
     * @return string
     */
    protected function _getOrdersTrackingCode()
    {
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $collection = Mage::getResourceModel('sales/order_collection')
            ->addFieldToFilter('entity_id', array('in' => $orderIds));
        $result = array();
        $result[] = "ga('require', 'ecommerce')";
        foreach ($collection as $order) {
            $result[] = sprintf("ga('ecommerce:addTransaction', {
'id': '%s',
'affiliation': '%s',
'revenue': '%s',
'tax': '%s',
'shipping': '%s'
});",
                $order->getIncrementId(),
                $this->jsQuoteEscape(Mage::app()->getStore()->getFrontendName()),
                $order->getBaseGrandTotal(),
                $order->getBaseTaxAmount(),
                $order->getBaseShippingAmount()
            );
            foreach ($order->getAllVisibleItems() as $item) {
                $result[] = sprintf("ga('ecommerce:addItem', {
'id': '%s',
'sku': '%s',
'name': '%s',
'category': '%s',
'price': '%s',
'quantity': '%s'
});",
                    $order->getIncrementId(),
                    $this->jsQuoteEscape($item->getSku()),
                    $this->jsQuoteEscape($item->getName()),
                    null, // there is no "category" defined for the order item
                    $item->getBasePrice(),
                    $item->getQtyOrdered()
                );
            }
            $result[] = "ga('ecommerce:send');";
        }
        return implode("\n", $result);
    }

    /**
     * Is sa available
     *
     * @return bool
     */
    protected function _isAvailable()
    {
        return Mage::helper('skroutzanalytics')->isSkroutzAnalyticsAvailable();
    }

    /**
     * Render SA tracking scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->_isAvailable()) {
            return '';
        }
        return parent::_toHtml();
    }
}
