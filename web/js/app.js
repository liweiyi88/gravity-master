/**
 * Created by emilychen on 18/01/2016.
 */
$(document).ready(function()
{

    $('body').on('click','.search-input',function(e)
    {
        $('.result-wrapper').show();
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('.search-input').length) {
            $('.result-wrapper').hide();
        }
    });



    var timeout = null
    $('.search-input').on('keyup', function() {
        var text = this.value
        clearTimeout(timeout)
        timeout = setTimeout(function() {
            // Do AJAX shit here
            var url = $('#ajax-product').val();
            // run ajax query to update b_made time
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    productName:$('.search-input').val()
                },
                error: function(data) {
                    // error, go back to start
                    //window.location.href = window.location.href;
                },
                success: function(data) {

                    var html = '<ul>';
                    for(var i=0; i< data.length; i++)
                    {
                        html += '<li><a href="https://www.google.com.au">'+data[i].name+'</a></li>';
                    }

                    html += '</ul>';

                    $('.result-text').html(html);
                }
            });


        }, 500)
    })

});