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

$nama_ttd = $data->nama_ttd;
$kab_kota_notaris = $data->kab_kota_notaris;
$nama_notaris = $data->nama_notaris;
$kab_kot_pengesahan = $data->kab_kot_pengesahan;
$tanggal_pengesahan = $data->tanggal_pengesahan;
$tanggal_pengesahan_english = $data->tanggal_pengesahan_english;
$nomor_ahu = $data->nomor_ahu;
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Inter:wght@400;700&display=swap');
    
    body {
        background-color: #f3f4f6;
        font-family: 'Times New Roman', Times, serif;
    }

    .certificate-container {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 2rem auto;
        background: white;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        border: 2px solid #1a365d;
        position: relative;
    }

    .bilingual-label {
        font-weight: bold;
        font-size: 0.95rem;
        color: #1a202c;
    }

    .bilingual-sub {
        font-style: italic;
        font-size: 0.85rem;
        color: #4a5568;
        display: block;
    }

    .content-text {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .section-box {
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    @media print {
        body { background: white; margin: 0; }
        .certificate-container { 
            box-shadow: none; 
            margin: 0; 
            width: 100%;
            border: none;
        }
        .no-print { display: none; }
    }

    .seal-placeholder {
        width: 120px;
        height: 120px;
        border: 2px dashed #cbd5e0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        color: #a0aec0;
        text-align: center;
        margin: 10px auto;
    }
</style>
<div class="no-print text-center mb-6">
    <button onclick="window.print()" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition">
        Cetak PDF
    </button>
</div>

<div class="certificate-container mx-auto">
    <div class="section-box grid grid-cols-12 gap-4">
        <div class="col-span-5">
        </div>
        <div class="col-span-7 italic text-right">
            <div id="qrcode-seal" style="width: 120px; height: 120px; margin: 10px auto; display: flex; justify-content: center; align-items: center;"></div>
        </div>
    </div>
    <!-- 1. Negara -->
    <div class="section-box grid grid-cols-12 gap-4">
        <div class="col-span-5">
            <span class="bilingual-label">1. Negara Republik Indonesia</span>
            <span class="bilingual-sub">Republic Of Indonesia</span>
        </div>
        <div class="col-span-7 italic text-right">
            Dokumen publik ini<span class="bilingual-sub text-sm">This public document</span>
        </div>
    </div>

    <!-- 2. Penandatangan -->
    <div class="section-box">
        <span class="bilingual-label">2. telah di tandatangani oleh <?php echo $nama_ttd; ?></span>
        <span class="bilingual-sub">has been signed by <?php echo $nama_ttd; ?></span>
    </div>

    <!-- 3. Kapasitas -->
    <div class="section-box">
        <span class="bilingual-label">3. bertindak dalam kewenangan sebagai Notaris <?php echo $kab_kota_notaris; ?></span>
        <span class="bilingual-sub">acting in the capacity of Notaris <?php echo $kab_kota_notaris; ?></span>
    </div>

    <!-- 4. Segel/Cap -->
    <div class="section-box">
        <span class="bilingual-label">4. dibubuhi segel/cap Notaris <?php echo $nama_notaris; ?></span>
        <span class="bilingual-sub">bears the seal/stamp of <?php echo $nama_notaris; ?></span>
    </div>

    <!-- Certification Title -->
    <div class="text-center my-6">
        <span class="bilingual-label border-b-2 border-black pb-1">Disahkan</span>
        <span class="bilingual-sub">Certified</span>
    </div>

    <div class="grid grid-cols-2 gap-8">
        <!-- Left Side -->
        <div>
            <div class="mb-6">
                <span class="bilingual-label">5. di <?php echo $kab_kot_pengesahan; ?></span>
                <span class="bilingual-sub">at <?php echo $kab_kot_pengesahan; ?></span>
            </div>

            <div class="mb-6">
                <span class="bilingual-label">6. tanggal <?php echo $tanggal_pengesahan; ?></span>
                <span class="bilingual-sub">the <?php echo $tanggal_pengesahan_english; ?></span>
            </div>

            <div class="mb-6">
                <span class="bilingual-label">7. oleh Direktur Jenderal Administrasi Hukum Umum</span>
                <span class="bilingual-sub">by Director General of Legal Administrative Affairs</span>
            </div>
        </div>

        <div class="mb-6">
            <span class="bilingual-label">8. Nomor <?php echo $nomor_ahu; ?></span>
            <span class="bilingual-sub">No. <?php echo $nomor_ahu; ?></span>
        </div>

        <table>
            <tr>
                <td style="vertical-align: top; padding: 0;">
                    <div class="mb-4">
                        <span class="bilingual-label">9. Segel/Cap</span>
                        <span class="bilingual-sub">Seal/stamp</span>
                    </div>
                </td>
                <td style="vertical-align: top; padding: 0;" class="text-center">
                    <div class="mb-4">
                        <span class="bilingual-label">10. Tanda Tangan</span>
                        <span class="bilingual-sub">Signature</span>
                        <br>
                        <br>
                        <br>
                        <span class="bilingual-sub"><?php echo $nama_ttd; ?></span>
                        <span class="bilingual-sub">Direktur Jenderal Administrasi Hukum Umum</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://unpkg.com/easyqrcodejs@4.6.1/dist/easy.qrcode.min.js"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        var pdfUrl = "<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'public/dokumen/' . sanitize_file_name($nomor_ahu) . '.pdf'; ?>";
        var logoUrl = "<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'public/img/logo.png'; ?>"; 
        
        var options = {
            text: pdfUrl,
            width: 120,
            height: 120,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H, // Level H agar tetap bisa di-scan meskipun tertutup logo
            logo: logoUrl,
            logoWidth: 35,
            logoHeight: 35,
            logoBackgroundColor: '#ffffff',
            logoBackgroundTransparent: false
        };

        // Inisialisasi QR Code
        new QRCode(document.getElementById("qrcode-seal"), options);

        // Setelah QR Code selesai dibuat, hasilkan PDF dan simpan ke server secara otomatis
        setTimeout(function() {
            var element = document.querySelector('.certificate-container');
            var opt = {
              margin:       0,
              filename:     '<?php echo sanitize_file_name($nomor_ahu); ?>.pdf',
              image:        { type: 'jpeg', quality: 0.98 },
              html2canvas:  { scale: 2 },
              jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            // Menggunakan outputPdf('blob') untuk mengambil data binernya saja
            html2pdf().set(opt).from(element).outputPdf('blob').then(function (pdfBlob) {
                var formData = new FormData();
                formData.append('action', 'save_generated_pdf');
                formData.append('pdf_file', pdfBlob, opt.filename);
                formData.append('nomor_ahu', '<?php echo esc_js($nomor_ahu); ?>');
                formData.append('api_key', '<?php echo esc_js(get_option(QRCODE_APIKEY)); ?>'); 

                // Kirim ke server via AJAX
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
        }, 1000); // 1 detik jeda dipastikan cukup agar QR code dan logo di-render sempurna di DOM
    });
</script>