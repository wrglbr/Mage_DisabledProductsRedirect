<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of List
 *
 * @author BPMedia
 */
class BPMedia_Disabledproducts_Model_Observer
{

	

    public function catalogProductViewPredispatch(Varien_Event_Observer $observer)
    {
        Varien_Profiler::start(__METHOD__);
        
        $product_id = intval(Mage::app()->getRequest()->getParam('id'));
        $_product   = Mage::getSingleton('catalog/product')->load($product_id);
        
        if($_product->getStatus() == Mage_Catalog_Model_Product_Status::STATUS_DISABLED) {

            $category_ids = $_product->getCategoryIds();
            $last_id      = end($category_ids);
            $redirect_url = Mage::getSingleton("catalog/category")->load($last_id)->getUrl();
            Mage::getSingleton('core/session')->addNotice('The product you requested is currently not available.');
  
            Mage::app()->getResponse()
                       ->setRedirect($redirect_url, 302);
                  }
        
        
        Varien_Profiler::stop(__METHOD__);
    }  



}
