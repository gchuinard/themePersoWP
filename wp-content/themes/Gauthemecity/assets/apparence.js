console.log('Apparence');

(function ($)
{
    wp.customize('header_background', function (value) {
        value.bind(function (new_val)
        {
            $('.navbar').css('background-color', new_val);
        })
    })
})(jQuery)