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
        $this->addActions();
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
        if (!current_user_can('edit_products')) {
            echo json_encode(array('template' => 'error', 'error' => __('You are not allowed to edit products!', 'sesm')));
            exit();
        }
        $ajax = new Super_Easy_Stock_Manager_Ajax();
        $do =  isset($_REQUEST['do']) ? $_REQUEST['do'] : 'get_product';
        $sku = isset($_REQUEST['sku']) ? $_REQUEST['sku'] : '';
        $sku = htmlspecialchars($sku);
        switch ($do) {
            case 'get_product':
                echo $ajax->getProduct($sku);
                break;
            case 'add_quantities':
                echo $ajax->updateProduct('stock', $sku);
                break;
            case 'update_price':
                echo $ajax->updateProduct('price', $sku);
                break;
        }
        exit();
    }
}
