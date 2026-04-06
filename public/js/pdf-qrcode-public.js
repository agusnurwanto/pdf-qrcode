jQuery(document).ready(function($) {
	let loading = ''
        + '<div id="wrap-loading">'
        + '<div class="lds-hourglass"></div>'
        + '<div id="persen-loading"></div>'
        + '</div>';

    if (jQuery('#wrap-loading').length == 0) {
        jQuery('body').prepend(loading);
    }
});
jQuery(document).ready(function ($) {
    $('#pdf-qrcode-input-form').on('submit', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: '/pdfqrcode/wp-admin/admin-ajax.php',
            type: 'POST',
            data: formData + '&action=submit_pdf_qrcode_input',

            success: function (response) {
                console.log(response); // debug
                alert(response.data.message);
                location.reload();
            },
            error: function (err) {
                console.log(err);
                alert('Terjadi error');
            }
        });
    });
});