<?php

/**
 * Plugin Name: Super Easy Stock Manager
 * Class description: The Ajax functions. Saves Porducts to the database.
 * Author: DansArt.
 * Author URI: http://dev.dans-art.ch
 *
 */

class Super_Easy_Stock_Manager_Ajax
{
    /**
     * Reads out a Product from the Database
     *
     * @param [type] $sku
     * @return void
     */
    public function getProduct($sku)
    {
        $product = $this->loadProduct($sku);
        $result = array('template' => 'get', 'sku' => $sku);
        if (is_object($product)) {
            $result['post_type'] = $product->get_type();
            $result['title'] = $product->get_name();
            $result['stock_quantity'] = $product->get_stock_quantity();
            $result['price'] = $product->get_price();
            $result['regular_price'] = $product->get_regular_price();
            $result['sale_price'] = $product->get_sale_price();
            $result['description'] = substr($product->get_short_description(), 0, 50);
            return json_encode($result);
        }
        return json_encode($product);
    }
    /**
     * Updates a Product
     *
     * @param [type] $action
     * @param [type] $sku
     * @param [type] $value
     * @return void
     */
    public function updateProduct($action, $sku, $value)
    {
        $result = array('template' => 'update', 'sku' => $sku);
        if (empty($value)) {
            $result['template'] = 'error';
            $result['error'] = __('No Value Set!', 'sesm');
            return json_encode($result);
        }
        $product = $this->loadProduct($sku);
        if (is_object($product)) {
            $result['title'] = $product->get_title();
            switch ($action) {
                case 'price':
                    $sale_price = isset($_REQUEST['price_sale']) ? $_REQUEST['price_sale'] : '';
                    settype($sale_price, 'float');
                    $result['old_value'] = $product->get_regular_price() . '(' . $product->get_sale_price() . ')';
                    $result['new_value'] = $value . '(' . $sale_price . ')'; 
                    $result['name_value'] = __('Price','sesm');
                    $product->set_regular_price($value);
                    $product->set_sale_price($sale_price);
                    break;
                case 'increase':
                case 'decrease':
                    $old_val = $product->get_stock_quantity();
                    if ($old_val === null) {
                        $product->set_manage_stock(true);
                        $old_val = 0;
                    }

                    $new_val = ($action === 'increase') ? $old_val + $value : $old_val - $value;
                    $product->set_stock_quantity($new_val);
                    $result['old_value'] = $old_val;
                    $result['new_value'] = $new_val;
                    $result['name_value'] = __('Stock','sesm');
                    //echo $ajax->updateProduct('increase', $sku, $value);
                    break;
            }
            $result['save_status'] = $product->save();
            return json_encode($result);
        }
        return json_encode($product);
    }
    /**
     * Loads the Product with all its attributes and properties.
     * 
     *
     * @param [string] $sku - The Products SKU
     * @return mixed array on error, WP_Product Object on success
     */
    public function loadProduct($sku)
    {
        $result = array();
        $product_id = wc_get_product_id_by_sku($sku);
        if (empty($sku) or $product_id === 0) {
            $result['template'] = 'error';
            $result['sku'] = $sku;
            $result['error'] = __('Product not found', 'sesm');
            return $result;
        } else {
            return wc_get_product($product_id);
        }
    }
}
