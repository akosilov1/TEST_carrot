$(function () {
    var refreshBasket = function () {
        $(".input-refresh-form").prop("value", "Y");

        $.ajax({
            url: "/ajax/update_basket.php",
            data: $('#basket_form').serialize(),
            type: "post",
            success: function (response) {
                $('.basket').replaceWith(response);
                recalculateDeliveryPrice();
            }
        });
    };

    var recalculateDeliveryPrice = function () {
        submitForm();
    };

    $(document).on('click', '.amount a', function (e) {
        e.preventDefault();

        var input = $(this).parents('.amount').find('input'),
            inputVal = parseInt(input.val()),
            maximum = parseInt(input.attr('data-maximum')),
            minimum = parseInt(input.attr('data-minimum'));

        if ($(this).hasClass('plus')) {
            if (inputVal < maximum) {
                input.val(inputVal + 1);
            }
        } else if ($(this).hasClass('minus')) {
            if (inputVal > minimum) {
                input.val(inputVal - 1);
            }
        }

        refreshBasket();
    });

    $(document).on('change keypress', '.amount input', function (e) {
        if (e.which === 13 || e.type === 'change') {
            refreshBasket();
        }
    });

    $(document).on('change', '.gift input', function () {
        var need = ($(this).data('need') == 'N') ? 'Y' : 'N',
            id = $(this).data('id');

        $.ajax({
            url: '/ajax/basket.php',
            type: 'post',
            dataType: 'html',
            data: 'mode=addGift&id=' + id + '&need=' + need
        });
    });

    recalculateDeliveryPrice();
});

