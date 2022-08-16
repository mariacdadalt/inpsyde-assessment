import "./Index.scss";

jQuery(document).ready(function ($) {

    console.log(pluginObj);

    $('.inpsyde-open-modal').on('click', function (event) {

        $('.inpsyde-modal__body').html('<div class="lds-dual-ring"></div>');

        var data = {
            action: pluginObj.action,
            nonce: pluginObj.nonce,
            id: $(this).data('id')
        };

        var ajax_post = $.post(pluginObj.ajaxUrl, data, function (response) {

            if (!response.success) {
                $('.inpsyde-messages__container').html(response.data);
                $('.inpsyde-modal__close').click();
                return;
            }

            $('.inpsyde-modal__body').html(response.data);
        });
    });
});