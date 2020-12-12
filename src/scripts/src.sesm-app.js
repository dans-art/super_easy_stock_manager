/*
  Project: Super Simple Stock Manager
  Author: Dansart
 */

import * as tools from './modules/tools.js';
//import overlay from './modules/overlay.js';


var sesm_do = '';

$(document).on('keypress',function(e) {
    if(e.which == 13) {
        sesmAjax();
        $('#sesm_sku_input').val('');
    }
});


$('#sesm_buttons span').click(function () {
    sesm_do = $(this).data('do');
    $('#sesm_input input').hide();
    $('#sesm_sku_input').show();
    $('.sesm_input.'+sesm_do).show();
    $('#sesm_buttons span.current').removeClass('current');
    $(this).addClass('current');
});

function sesmAjax() {
    var sku_input = $('#sesm_sku_input').val();
    var quantity_input = $('.sesm_input.add_quantities').val();
    var price_input = $('.sesm_input.update_price').val();
    var price_sale_input = $('.sesm_input.update_price.sale').val();
    var data = {
        action: 'sesm-ajax',
        do: sesm_do,
        sku: sku_input,
        quantity : quantity_input,
        price : price_input,
        price_sale : price_sale_input,
    };
    $.post(wp_site_url + '/wp-admin/admin-ajax.php', data, function (response) {
        addToHistory($.parseJSON(response))
    });
}

function addToHistory(dataObj){
    var template = historyTemplate[dataObj.template];
    $.each(dataObj, function(index, value) {
        template = template.replace('${'+index+'}',value);
    });
    $('#sesm_history').prepend(template);
}
