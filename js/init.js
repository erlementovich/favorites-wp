jQuery(document).ready(function ($) {
    $('body').on('click', '.wfm-favorites-link a', function (e) {
        var action = $(this).data('action');
        $.ajax({
            type: 'POST',
            url: wfmFavorites.url,
            data: {
                security: wfmFavorites.nonce,
                action: 'wfm_' + action,
                postId: wfmFavorites.postId
            },
            beforeSend: function () {
                $('.wfm-favorites-toggle').fadeOut(300, function () {
                    $('.wfm-favorites-hidden').fadeIn();
                });
            },
            success: function (res) {
                $('.wfm-favorites-hidden').fadeOut(300, function () {
                    $('.wfm-favorites-link').html(res);
                    $('.wfm-favorites-hidden').fadeOut();//это чтобы скрыть только что отрендеренный loader
                });
            },
            error: function () {
                alert('Ошибка!');
            }
        });
        e.preventDefault();
    });
});