$(document).ready(function () {
    $(document).on('click', '.js-fancybox-close', function (e) {
        e.preventDefault();
        $.fancybox.close();
    });

    var initializeInputMask;

    (initializeInputMask = function () {
        var listCountries = $.masksSort($.masksLoad("/bitrix/templates/carrot/js/phone_mask/phone-codes.json"), ['#'], /[0-9]|#/, "mask"),
            listRU = $.masksSort($.masksLoad("/bitrix/templates/carrot/js/phone_mask/phones-ru.json"), ['#'], /[0-9]|#/, "mask"),
            maskOpts = {
                inputmask: {
                    definitions: {
                        '#': {
                            validator: "[0-9]",
                            cardinality: 1
                        }
                    }
                },
                match: /[0-9]/,
                replace: '#',
                listKey: "mask"
            };

        $('input[name="mode"]').change(function () {
            $('.phone_mask').inputmask("remove");

            if ($('#is_world').is(':checked')) {
                $('.phone_mask').inputmasks($.extend(true, {}, maskOpts, {
                    list: listCountries
                }));
            } else {
                $('.phone_mask').inputmasks($.extend(true, {}, maskOpts, {
                    list: listRU
                }));
            }
        });

        $('input[name="mode"]').change();

        $('.phone_mask').blur(function () {
            if ($(this).val().indexOf('_') >= 0) {
                $('.phone_mask').val('');
            }
        });

        $(".email_mask").inputmask({alias: "email", clearIncomplete: true});
    })();

    BX.addCustomEvent('onAjaxSuccess', function () {
        initializeInputMask();
    });
});