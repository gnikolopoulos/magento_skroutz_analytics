<?php
/**
 * SkroutzAnalytics data helper
 *
 * @category   ID
 * @package    ID_SkroutzAnalytics
 */
class ID_SkroutzAnalytics_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Config paths for using throughout the code
     */
    const XML_PATH_ACTIVE        = 'skroutzanalytics/analytics/active';
    const XML_PATH_STOREID       = 'skroutzanalytics/analytics/store';

    /**
     * Whether skroutz analytics is ready to use
     * @param mixed $store
     * @return bool
     */
    public function isSkroutzAnalyticsAvailable($store = null)
    {
        $storeId = Mage::getStoreConfig(self::XML_PATH_STOREID, $store);
        return $storeId && Mage::getStoreConfigFlag(self::XML_PATH_ACTIVE, $store);
    }

    /**
     * Get Skroutz Analytics store id
     * @param string $store
     * @return string
     */
    public function getAccountId($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_STOREID, $store);
    }
}
