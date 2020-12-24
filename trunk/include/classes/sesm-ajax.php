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
        $type = $product->get_type();
        if (is_object($product)) {
            $result['post_type'] = $this->getProductType($type);
            $result['title'] = $product->get_name();
            $result['stock_quantity'] = $product->get_stock_quantity() ?: "-";
            $result['price'] = $product->get_price() ?: "-";
            $result['currency'] = get_woocommerce_currency();
            $result['regular_price'] = $product->get_regular_price() ?: "-";
            $result['sale_price'] = $product->get_sale_price() ?: "-";
            $result['description'] = substr($product->get_short_description(), 0, 50);
            $result['image'] = $product->get_image('thumbnail');
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
            $result['error'] = __('No value set!', 'sesm');
            return json_encode($result);
        }
        $product = $this->loadProduct($sku);
        if (is_object($product)) {
            if($product->get_type() === 'variable'){
                $result['template'] = 'error';
                $result['error'] = __('You can\'t change the values of that product, because it has variations. Please change the value of the variation itself.', 'sesm');
                return json_encode($result); 
            }

            $result['title'] = $product->get_title();
            switch ($action) {
                case 'price':
                    $regular_price = isset($_REQUEST['price']) ? $_REQUEST['price'] : '';
                    $sale_price = isset($_REQUEST['price_sale']) ? $_REQUEST['price_sale'] : '';
                    $type = $product->get_type();
                    if(!empty($regular_price)) {
                        settype($regular_price, 'float');
                    }
                    if(!empty($sale_price)) {
                        settype($sale_price, 'float');
                    }
                    if (($regular_price > 0 and $sale_price > 0) and ($sale_price > $regular_price)) {
                        $result['template'] = 'error';
                        $result['error'] = __('Sale price has to be smaller than the regular price!', 'sesm');
                        return json_encode($result);
                    }
                    $result['template'] = 'updatePrice';
                    $result['post_type'] = $this->getProductType($type);
                    $result['old_regular'] = $product->get_regular_price() ?: "-";
                    $result['old_sale'] = $product->get_sale_price() ?: "-";
                    $result['new_regular'] = $regular_price;
                    $result['new_sale'] = $sale_price;
                    $result['currency'] = get_woocommerce_currency();
                    if(!empty($regular_price)) {
                        $product->set_regular_price($regular_price);
                        $result['css_regular'] = '';
                    }else{
                        $result['css_regular'] = 'hide';
                    }
                    if(!empty($sale_price)) {
                        $product->set_sale_price($sale_price);
                        $result['css_sale'] = '';
                    }else{
                        $result['css_sale'] = 'hide';
                    }
                    break;
                case 'stock':
                    $result['manage_stock'] = $product->get_manage_stock();
                    $old_val = $product->get_stock_quantity();
                    $manage_stock = $product->get_manage_stock();
                    if ($manage_stock !== true ) {
                        $product->set_manage_stock(true);
                        $old_val = 0;
                    }
                    $increase = ($value > 0)?true:false;
                    $value_positive = abs($value);
                    $new_val = ($increase) ? $old_val + $value_positive : $old_val - $value_positive;
                    if($increase){
                        $result['change_txt'] = sprintf(__('The stock has been increased by %d to %d', 'sesm'), $value_positive, $new_val);
                        $result['direction'] = 'increase';
                    }else{
                        $result['change_txt'] = sprintf(__('The stock has been decreased by %d to %d', 'sesm'), $value_positive, $new_val);
                        $result['direction'] = 'decrease';
                    }
                    $product->set_stock_quantity($new_val);
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
            $result['error'] = sprintf(__('Product not found for SKU: %s', 'sesm'), $sku);
            return $result;
        } else {
            return wc_get_product($product_id);
        }
    }

    /**
     * Returns the Product type for humans to understand and translates it.
     *
     * @param  string $type - Product Type
     * @return void
     */
    public function getProductType($type){
        switch ($type) {
            case 'simple':
                   return __('Simple Product', 'sesm'); 
                break;
            
            case 'variable':
                return __('Product with Variations', 'sesm'); 
                break;
            
            case 'variation':
                return __('Variation of Product', 'sesm'); 
                break;
            
            default:
            return $type; 
                break;
        }
    }
}
