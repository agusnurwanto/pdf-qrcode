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
        <span class="bilingual-label">2. telah di tandatangani oleh xxx xxx xxx</span>
        <span class="bilingual-sub">has been signed by xxx xxx xxx</span>
    </div>

    <!-- 3. Kapasitas -->
    <div class="section-box">
        <span class="bilingual-label">3. bertindak dalam kewenangan sebagai Notaris Kabupaten xxx</span>
        <span class="bilingual-sub">acting in the capacity of Notaris Kabupaten xxx</span>
    </div>

    <!-- 4. Segel/Cap -->
    <div class="section-box">
        <span class="bilingual-label">4. dibubuhi segel/cap Notaris xxx xxx xxx</span>
        <span class="bilingual-sub">bears the seal/stamp of xxx xxx xxx</span>
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
                <span class="bilingual-label">5. di Jakarta</span>
                <span class="bilingual-sub">at Jakarta</span>
            </div>

            <div class="mb-6">
                <span class="bilingual-label">6. tanggal 17 Maret 2026</span>
                <span class="bilingual-sub">the 17th day of March 2026</span>
            </div>

            <div class="mb-6">
                <span class="bilingual-label">7. oleh Direktur Jenderal Administrasi Hukum Umum</span>
                <span class="bilingual-sub">by Director General of Legal Administrative Affairs</span>
            </div>
        </div>

        <div class="mb-6">
            <span class="bilingual-label">8. Nomor AHU.AH.12.05.01-xxx Tahun xxxx</span>
            <span class="bilingual-sub">No. AHU.AH.12.05.01-xxx Tahun xxxx</span>
        </div>

        <table>
            <tr>
                <td style="vertical-align: top; padding: 0;">
                    <div class="mb-4">
                        <span class="bilingual-label">9. Segel/Cap</span>
                        <span class="bilingual-sub">Seal/stamp</span>
                        <div class="seal-placeholder">
                            [Segel Resmi<br>Kemenkumham]
                        </div>
                    </div>
                </td>
                <td style="vertical-align: top; padding: 0;" class="text-center">
                    <div class="mb-4">
                        <span class="bilingual-label">10. Tanda Tangan</span>
                        <span class="bilingual-sub">Signature</span>
                        <br>
                        <br>
                        <br>
                        <span class="bilingual-sub">xxx</span>
                        <span class="bilingual-sub">Direktur Jenderal Administrasi Hukum Umum</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>