/*
 * NOTE: all actions are prefixed by plugin shortnam_action_name
 */
var selected_slide = 0;
var total_sections = 0;
var boxes = new Array();	//checking bound connection

jQuery(function ($) {

    /* ============= setting prices dynamically on product page ============= */
    $(".nm-productmeta-box").find('select,input:checkbox,input:radio').on('change', function () {
        //console.log('im dynamic');

        if ($(".single_variation .price .amount").length > 0) {
            var base_amount = $(".single_variation .price ins .amount").text(); //actual amount of the product
            base_amount = base_amount.replace(/[^\d.]/g, ''); //replace all strings that are not digits or decimal point with space

            base_amount_arr = base_amount.split('.');
            base_amount = parseFloat(base_amount_arr[1]).toFixed(2);

            $price = $(".single_variation .price");
        } else {
            var $price = $('.amount').closest('.price');
            var base_amount = $('.amount').closest('.price').find('.amount').text();

            base_amount = base_amount.replace(/[^\d.]/g, '');

            //Separate base amount at decimal, parse it to float and fix it to 2 decimal digits
            base_amount_arr = base_amount.split('.');
            base_amount = parseFloat(base_amount_arr[1]).toFixed(2);
        }

        alert(base_amount);

    });

});