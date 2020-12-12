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
    <input class="sesm_input add_quantities remove_quantities" style="display: none;" type="text" placeholder="Anzahl" />
    <input class="sesm_input update_price" style="display: none;" type="text" placeholder="Preis"/>
    <input class="sesm_input update_price sale" style="display: none;" type="text" placeholder="Angebots-Preis"/>
    </div>
    <div>
        <input id="sesm_sku_input" style="display: none;" type="text" placeholder="SKU" value="36103" />
    </div>
</section>
<section id="sesm_history">

</section>