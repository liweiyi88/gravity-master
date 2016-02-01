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



    $('body').on('mouseover','.dropdown-toggle',function()
    {
        var mq = window.matchMedia( "(min-width: 766px)" );

        if (mq.matches)
        {
            $('.dropdown-menu.more').hide();
            $(this).parent().find('.dropdown-menu.more').show();
        }
    });


    //for mobile
    $('body').on('click','.dropdown-toggle',function()
    {
        var mq = window.matchMedia( "(max-width: 765px)" );

        if (mq.matches)
        {
            $(this).parent().find('.dropdown-menu.more').toggle();
        }
    });




    $(document).on('mouseover', function(event) {
        var mq = window.matchMedia( "(min-width: 766px)" );

        if (mq.matches)
        {
            if (!$(event.target).closest('.dropdown-toggle').length) {
                if (!$(event.target).closest('.dropdown-menu.more').length)
                {
                    $('.dropdown-menu.more').hide();
                }

            }
        }
    });


    $(document).on('click', function(event) {
        var mq = window.matchMedia( "(min-width: 766px)" );

        if (mq.matches)
        {
            if (!$(event.target).closest('.dropdown-toggle').length) {
                $('.dropdown-menu.more').hide();
            }
        }
    });



    var timeout = null
    $('.search-input').on('keyup', function()
    {
        var text = this.value;
        if(text =='')
        {
            $('.result-text').html('请输入产品名称进行查询');
            clearTimeout(timeout);
        }
        else
        {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                if(text != '')
                {
                    console.log(text);
                    $('.result-text').html('<p>搜索中... <i class="fa fa-circle-o-notch fa-spin"></i></p>');
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

                            if(data.length > 0)
                            {
                                var html = '<ul>';
                                for(var i=0; i< data.length; i++)
                                {
                                    html += '<li><a href="https://www.google.com.au">'+data[i].name+'</a></li>';
                                }

                                html += '</ul>';
                            }
                            else
                            {
                                html = '未找到相关物品';
                            }


                            $('.result-text').html(html);
                        }
                    });
                }
            }, 500)

        }
    });

});