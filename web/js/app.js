/**
 * Created by emilychen on 18/01/2016.
 */
$(document).ready(function()
{

    $('body').on('focus','.search-input',function()
    {
        $('.result-wrapper').show();
    });

    $('body').on('focusout','.search-input',function()
    {
        $('.result-wrapper').hide();
    });

});