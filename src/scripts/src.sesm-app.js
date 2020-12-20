/*
  Project: Super Simple Stock Manager
  Author: Dansart
 */

import * as tools from './modules/tools.js';
//import overlay from './modules/overlay.js';


var sesm_do = '';

/**
 * Runs the Ajax function as soon as "Enter" has been pressed.
 */
$(document).on('keyup',function(e) {
    if(e.which == 13) {
        sesmAjax();
        $('#sesm_sku_input').val('');
    }
});

/**
 * Changes the visability of the input fields. Runs on Button click
 */
$('#sesm_buttons span').click(function () {
    sesm_do = $(this).data('do');
    $('#sesm_input input').hide();
    $('#sesm_input label').hide();
    $('#sesm_input .quant_flex_group').hide();

    $('#sesm_sku_input').show();
    $('#sesm_sku_input').next().show();
    $('#sesm_sku_input').focus();

    $('.sesm_input.'+sesm_do).show();
    $('.sesm_label.'+sesm_do).show();

    $('#sesm_buttons span.current').removeClass('current');
    $(this).addClass('current');
});
/**
 * Adds the value of one to the existing value in sesm_quant
 */
$('#add_quant_btn').click(function(){
    var quant = parseInt($('#sesm_quant').val());
    $('#sesm_quant').val( quant + 1 );
    $('#sesm_sku_input').focus();
});

/**
 * Removes the value of one to the existing value in sesm_quant
 */
$('#remove_quant_btn').click(function(){
    var quant = parseInt($('#sesm_quant').val());
    $('#sesm_quant').val( quant - 1 );
    $('#sesm_sku_input').focus();
});

/**
 * Sends the Ajax request and delivers the result to the addToHistory function
 */
function sesmAjax() {
    var sku_input = $('#sesm_sku_input').val();
    var quantity_input = $('#sesm_quant').val();
    var price_input = $('.sesm_input.update_price').val();
    var price_sale_input = $('.sesm_input.update_price.sale').val();
    $('#sesm_sku_input').addClass('input_loading');
    var data = {
        action: 'sesm-ajax',
        do: sesm_do,
        sku: sku_input,
        quantity : quantity_input,
        price : price_input,
        price_sale : price_sale_input,
    };
    $.post(wp_site_url + '/wp-admin/admin-ajax.php', data, function (response) {
        addToHistory($.parseJSON(response));
        $('#sesm_sku_input').removeClass('input_loading');
    });
}

/**
 * Adds the response from sesmAjax function to the history section
 * @param {object} dataObj - Contains the result from the ajax request
 */
function addToHistory(dataObj){
    var template = historyTemplate[dataObj.template];
    $.each(dataObj, function(index, value) {
        value = colorValues(index, value);
        template = template.replace('${'+index+'}',value);
    });
    $('#sesm_history').addClass('active');
    $('#sesm_history').prepend(template);
}

function colorValues(name, value){
    switch (name) {
        case 'stock_quantity':
        case 'regular_price':
        case 'sale_price':
            var val_number = parseInt(value);
            if(val_number < 1){
                return "<span class='red'>"+val_number+"</span>";
            }else{
                return value;
            }
            break;
    
        default:
            return value;
            break;
    }
    
}
