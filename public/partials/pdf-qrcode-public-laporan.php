<?php
global $wpdb;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$data = $wpdb->get_row(
    $wpdb->prepare(
        "SELECT * FROM qrcode_data_dokumen WHERE id = %d",
        $id
    )
);

if (!$data) {
    echo "Data tidak ditemukan";
    exit;
}

$nomor_ahu = $data->nomor_ahu; 

$file_path_check = plugin_dir_path(__FILE__) . '../dokumen/' . $nomor_ahu . '.pdf';
$file_exists = file_exists($file_path_check);

$force = isset($_GET['force']);

$regen = (
    $force ||
    $data->cekupdate == 1 ||
    !$file_exists
);

$nama_ttd = $data->nama_ttd;
$kab_kota_notaris = $data->kab_kota_notaris;
$nama_notaris = $data->nama_notaris;
$kab_kot_pengesahan = $data->kab_kot_pengesahan;
$tanggal_pengesahan = $data->tanggal_pengesahan;
$tanggal_pengesahan_english = $data->tanggal_pengesahan_english;

$logo_id = carbon_get_theme_option('crb_logo_qrcode');
$logo_url = $logo_id ? wp_get_attachment_url($logo_id) : '';
?>

<style>
html, body {
    margin: 0 !important;
    padding: 0 !important;
    background: #fff !important;
    font-family: Arial, sans-serif;
    font-size: 7.5pt;
    line-height: 1.3;
    color: #000;
}

.document-container {
    width: 210mm;
    min-height: 277mm;
    margin: 0 auto;
    padding-top: 2.5cm;
    padding-bottom: 0.49cm;
    padding-left: 2.96cm;
    padding-right: 2.96cm;
    background: #fff;
    box-sizing: border-box;
}

.qr-section {
    display: flex;
    justify-content: flex-end;
    margin: 0 0 20px 0;
}

.section {
    margin-bottom: 12px;
}

.italic-eng {
    font-style: italic;
    font-weight: normal !important;
    display: block;
    margin-top: 2px;
    margin-left: 13px;
}
.indent {
    margin-left: 0;
}

.grid-layout {
    width: 100%;
    display: table;
    table-layout: fixed;
    margin-bottom: 12px;
}

.grid-layout > div {
    display: table-cell;
    vertical-align: top;
}

.middle-align-col {
    padding-left: 0;
    position: relative;
    left: -8px; 
}

.signature-space {
    height: 70px;
    margin: 5px 0;
}

.center-text {
    text-align: center;
    margin: 20px 0;
}
@page {
    size: A4;
    margin-top: 2.5cm;
    margin-bottom: 0.49cm;
    margin-left: 2.96cm;
    margin-right: 2.96cm;
}
@media print {
    html, body {
        margin: 0 !important;
        padding: 0 !important;
    }

    .document-container {
        margin: 0 !important;
        box-shadow: none !important;
    }
}
</style>

<div class="document-container">

    <div class="qr-section">
        <div id="qrcode-seal" style="width:90px;height:90px;"></div>
    </div>

    <div class="section">
        <p><strong>1. Negara Republik Indonesia</strong><br>
        <span class="italic-eng">Republic Of Indonesia</span></p>
    </div>

    <div style="text-align:center; margin:20px 0;">
        <p><strong>Dokumen publik ini</strong><br>
        <span class="italic-eng indent">This public document</span></p>
    </div>

    <div class="section">
        <p><strong>2. telah ditandatangani oleh <?php echo $nama_ttd; ?></strong><br>
        <span class="italic-eng">has been signed by <?php echo $nama_ttd; ?></span></p>
    </div>

    <div class="section">
        <p><strong>3. bertindak dalam kewenangan sebagai Notaris <?php echo $kab_kota_notaris; ?> </strong><br>
        <span class="italic-eng">acting in the capacity of Notaris <?php echo $kab_kota_notaris; ?></span></p>
    </div>

    <div class="section">
        <p><strong>4. dibubuhi segel/cap Notaris <?php echo $nama_notaris; ?></strong><br>
        <span class="italic-eng">bears the seal/stamp of Notaris <?php echo $nama_notaris; ?></span></p>
    </div>

    <div class="grid-layout" style="margin:35px 0;">
        <div></div>
        <div class="middle-align-col">
            <p><strong>Disahkan</strong><br>
            <span class="italic-eng indent">Certified</span></p>
        </div>
    </div>

    <div class="grid-layout">

        <div>
            <p><strong>5. di <?php echo $kab_kot_pengesahan; ?></strong><br>
            <span class="italic-eng">at <?php echo $kab_kot_pengesahan; ?></span></p>
        </div>

        <div class="middle-align-col">
            <p><strong>6. tanggal <?php echo $tanggal_pengesahan; ?> </strong><br>
            <span class="italic-eng">the <?php echo $tanggal_pengesahan_english; ?></span></p>
        </div>

    </div>

    <div class="section">
        <p><strong>7. oleh Direktur Jenderal Administrasi Hukum Umum </strong><br>
        <span class="italic-eng">by Director General of Legal Administrative Affairs</span></p>
    </div>

    <div class="section">
        <p><strong>8. Nomor <?php echo $nomor_ahu; ?></strong><br>
        <span class="italic-eng">No. <?php echo $nomor_ahu; ?></span></p>
    </div>

    <div class="grid-layout" style="margin-top:20px;">

        <div>
            <p><strong>9. Segel/Cap</strong><br>
            <span class="italic-eng">Seal/Stamp</span></p>
        </div>

        <div class="middle-align-col">
            <p><strong>10.Tanda Tangan</strong><br>
            <span class="italic-eng"> Signature</span></p>

            <div class="signature-space"></div>

            <span class="italic-eng"><?php echo $nama_ttd; ?></span></p>
            <span class="italic-eng">Direktur Jenderal Administrasi Hukum Umum</span></p>
        </div>

    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://unpkg.com/easyqrcodejs@4.6.1/dist/easy.qrcode.min.js"></script>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {

    var regen = <?php echo $regen ? 'true' : 'false'; ?>;

    var pdfUrl = "<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'public/dokumen/' . sanitize_file_name($nomor_ahu) . '.pdf'; ?>";
    var logoUrl = "<?php echo esc_url($logo_url); ?>";

    if (!logoUrl) {
        console.warn("Logo QR belum di-set di admin");
    }

    var options = {
        text: pdfUrl,
        width: 90,
        height: 90,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H,
        logo: logoUrl,
        logoWidth: 35,
        logoHeight: 35,
        logoBackgroundColor: '#ffffff',
        logoBackgroundTransparent: false
    };

    new QRCode(document.getElementById("qrcode-seal"), options);

    if (regen) {

        setTimeout(function() {
            var element = document.querySelector('.document-container');

            var opt = {
              margin: 0,
              filename: '<?php echo sanitize_file_name($nomor_ahu); ?>.pdf',
              image: { type: 'jpeg', quality: 0.98 },
              html2canvas: { scale: 2.31 },
              jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).outputPdf('blob').then(function (pdfBlob) {

                var formData = new FormData();
                formData.append('action', 'save_generated_pdf');
                formData.append('pdf_file', pdfBlob, opt.filename);
                formData.append('nomor_ahu', '<?php echo esc_js($nomor_ahu); ?>');
                formData.append('api_key', '<?php echo esc_js(get_option(QRCODE_APIKEY)); ?>');

                fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Autosave PDF status:', data);
                })
                .catch(err => console.error('Error saat menyimpan PDF otomatis:', err));
            });

        }, 1000);

    } else {
        console.log("PDF sudah valid → tidak generate ulang");
    }

});
</script>