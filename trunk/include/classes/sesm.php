<?php

/**
 * Plugin Name: Super Easy Stock Manager
 * Class description: Main Class.
 * Author: Dan's Art
 * Author URI: http://dev.dans-art.ch
 *
 */
class Super_Easy_Stock_Manager extends Super_Easy_Stock_Manager_Helper
{


    /**
     * Adds the Ajax Functions
     * Enqueues Scripts
     */
    public function __construct()
    {
        //register Ajax
        add_action('wp_ajax_sesm-ajax', [$this, 'sesmAjax']);
        add_action('wp_ajax_nopriv_sesm-ajax', [$this, 'sesmAjax']);
        $this->enqueueScripts();
    }
    /**
     * Loads the Frontend Template
     *
     * @return void
     */
    public function getFrontend()
    {
        $tmp = $this->getTemplate('frontend');
        return $this->loadTemplate($tmp);
    }

    /**
     * Main Method for handling the Ajax Calls
     *
     * @return string echoes the output of the ajax function
     */
    public function sesmAjax()
    {
        $ajax = new Super_Easy_Stock_Manager_Ajax();
        $do =  isset($_REQUEST['do'])?$_REQUEST['do']:'get_product';
        $sku = isset($_REQUEST['sku'])?$_REQUEST['sku']:'';
        $sku = htmlspecialchars($sku);
        $quantity = isset($_REQUEST['quantity'])?$_REQUEST['quantity']:'';
        $price = isset($_REQUEST['price'])?$_REQUEST['price']:'';
        settype($quantity, 'float');
        settype($price, 'float');
        switch ($do) {
            case 'get_product':
                echo $ajax->getProduct($sku);
                break;
            case 'add_quantities':
                echo $ajax->updateProduct('increase', $sku, $quantity);
                break;
            case 'remove_quantities':
                echo $ajax->updateProduct('decrease', $sku, $quantity);
                break;
            case 'update_price':
                echo $ajax->updateProduct('price', $sku, $price);
                break;
        }
        exit();
    }
}
