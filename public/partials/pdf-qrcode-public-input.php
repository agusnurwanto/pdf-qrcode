<?php
$api_key = get_option(QRCODE_APIKEY);
$laporan_pdf = $this->functions->generatePage(array(
    'nama_page' => 'Laporan Dokumen PDF',
    'content' => '[display_laporan_dokumen_pdf]',
    'show_header' => 1,
    'no_key' => 1,
    'post_status' => 'private'
));
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <!-- Tombol Laporan di Atas atau di Bawah, kita taruh di atas form atau di bawah. User tidak menspesifikkan, biarkan di luar form atau di dalam card -->
            <div class="text-center mb-3">
                <button class="btn btn-secondary" onclick="window.location.href='<?php echo esc_url($laporan_pdf['url']); ?>'">Lihat Laporan Dokumen PDF</button>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-white" style="color: white;">Input Laporan Dokumen</h4>
                </div>
                <div class="card-body">
                    <div id="pdf-qrcode-message"></div>
                    <form id="pdf-qrcode-input-form">
                        <div class="form-group mb-3">
                            <label for="nama_ttd" class="form-label font-weight-bold fw-bold">Nama TTD:</label>
                            <input type="text" name="nama_ttd" id="nama_ttd" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kab_kota_notaris" class="form-label font-weight-bold fw-bold">Kab/Kota Notaris:</label>
                            <input type="text" name="kab_kota_notaris" id="kab_kota_notaris" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama_notaris" class="form-label font-weight-bold fw-bold">Nama Notaris:</label>
                            <input type="text" name="nama_notaris" id="nama_notaris" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kab_kot_pengesahan" class="form-label font-weight-bold fw-bold">Kab/Kota Pengesahan:</label>
                            <input type="text" name="kab_kot_pengesahan" id="kab_kot_pengesahan" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal_pengesahan" class="form-label font-weight-bold fw-bold">Tanggal Pengesahan:</label>
                            <input type="text" name="tanggal_pengesahan" id="tanggal_pengesahan" class="form-control" placeholder="Contoh: 1 Januari 2023">
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal_pengesahan_english" class="form-label font-weight-bold fw-bold">Tanggal Pengesahan (English):</label>
                            <input type="text" name="tanggal_pengesahan_english" id="tanggal_pengesahan_english" class="form-control" placeholder="Example: January 1st, 2023">
                        </div>
                        <div class="form-group mb-4">
                            <label for="nomor_ahu" class="form-label font-weight-bold fw-bold">Nomor AHU:</label>
                            <input type="text" name="nomor_ahu" id="nomor_ahu" class="form-control" value="AHU.AH.12.05.xx-xxxxx Tahun 2026">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" id="btn-submit-pdf-qrcode" class="btn btn-primary btn-block w-100">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#pdf-qrcode-input-form').on('submit', function(e) {
        e.preventDefault();

        // Kosongkan pesan dan disable form sejenak
        $('#pdf-qrcode-message').html('');
        var $btn = $('#btn-submit-pdf-qrcode');
        var originalBtnText = $btn.text();
        $btn.text('Menyimpan...').prop('disabled', true);

        var data = {
            action: 'submit_pdf_qrcode_input',
            api_key: '<?php echo $api_key; ?>',
            nama_ttd: $('#nama_ttd').val(),
            kab_kota_notaris: $('#kab_kota_notaris').val(),
            nama_notaris: $('#nama_notaris').val(),
            kab_kot_pengesahan: $('#kab_kot_pengesahan').val(),
            tanggal_pengesahan: $('#tanggal_pengesahan').val(),
            tanggal_pengesahan_english: $('#tanggal_pengesahan_english').val(),
            nomor_ahu: $('#nomor_ahu').val()
        };

        jQuery('#wrap-loading').show();
        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                jQuery('#wrap-loading').hide();
                if (response.success) {
                    $('#pdf-qrcode-message').html('<div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border: 1px solid #c3e6cb; border-radius: 4px;">' + response.data.message + '</div>');
                    $('#pdf-qrcode-input-form')[0].reset();
                } else {
                    $('#pdf-qrcode-message').html('<div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border: 1px solid #f5c6cb; border-radius: 4px;">' + response.data.message + '</div>');
                }
            },
            error: function() {
                jQuery('#wrap-loading').hide();
                $('#pdf-qrcode-message').html('<div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border: 1px solid #f5c6cb; border-radius: 4px;">Terjadi kesalahan koneksi saat menyimpan data.</div>');
            },
            complete: function() {
                $btn.text(originalBtnText).prop('disabled', false);
            }
        });
    });
});
</script>