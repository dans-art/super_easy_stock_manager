<section id="sesm_buttons">
    <span data-do="get_product">
        <span class="sesm_icon"><i class="fas fa-question"></i></span>
        <span class="sesm_text"><?php echo __("Get Info", "sesm"); ?></span>
    </span>
    <span data-do="add_quantities">
        <span class="sesm_icon"><i class="far fa-plus-square"></i></span>
        <span class="sesm_text"><?php echo __("Add Quantities", "sesm"); ?></span>
    </span>
    <span data-do="remove_quantities">
        <span class="sesm_icon"><i class="far fa-minus-square"></i></span>
        <span class="sesm_text"><?php echo __("Remove Quantities", "sesm"); ?></span>
    </span>
    <span data-do="update_price">
        <span class="sesm_icon"><i class="far fa-money-bill-alt"></i></span>
        <span class="sesm_text"><?php echo __("Update Price", "sesm"); ?></span>
    </span>
</section>
<section id="sesm_input">
    <div class="sesm_options">
    <label for="sesm_quant" class="sesm_label add_quantities remove_quantities"  style="display: none;"><?php echo __("Quantity", "sesm");?></label>
    <input id="sesm_quant" class="sesm_input add_quantities remove_quantities" style="display: none;" type="text" value="1" />

    <label for="sesm_price_reg" class="sesm_label update_price"  style="display: none;"><?php echo __("Price Regular", "sesm");?></label>
    <input id="sesm_price_reg" class="sesm_input update_price" style="display: none;" type="text" />

    <label for="sesm_price_sale" class="sesm_label update_price"  style="display: none;"><?php echo __("Price Sale", "sesm");?></label>
    <input id="sesm_price_sale" class="sesm_input update_price sale" style="display: none;" type="text"/>

    </div>
    <div>
        <label for="sesm_sku_input" style="display: none;"><?php echo __("SKU", "sesm");?></label>
        <input id="sesm_sku_input" style="display: none;" type="text" />
    </div>
</section>
<section id="sesm_history">

</section>