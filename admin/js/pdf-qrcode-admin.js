jQuery(document).ready(function($) {
	let loading = ''
        + '<div id="wrap-loading">'
        + '<div class="lds-hourglass"></div>'
        + '<div id="persen-loading"></div>'
        + '</div>';

    if (jQuery('#wrap-loading').length == 0) {
        jQuery('body').prepend(loading);
    }
	
	$("#btn-sql-migrate").on("click", function() {
		var $btn = $(this);
		$btn.prop("disabled", true).text("Migrating...");
		$("#sql-migrate-msg").html("Memproses...");
		
		$.ajax({
			url: ajaxurl,
			type: "POST",
			data: { action: "pdf_qrcode_migrate" },
			dataType: "json",
			success: function(res) {
				if (res.success) {
					$("#sql-migrate-msg").html("<span style=\'color:green;\'>Migrasi berhasil! Tabel siap digunakan.</span>");
				} else {
					$("#sql-migrate-msg").html("<span style=\'color:red;\'>Gagal: " + res.data.message + "</span>");
				}
			},
			error: function() {
				$("#sql-migrate-msg").html("<span style=\'color:red;\'>Kesalahan jaringan.</span>");
			},
			complete: function() {
				$btn.prop("disabled", false).text("Migrate SQL");
			}
		});
	});
});