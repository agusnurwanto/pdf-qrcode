<?php
$laporan_pdf = $this->functions->generatePage(array(
    'nama_page' => 'Laporan Dokumen PDF',
    'content' => '[display_laporan_dokumen_pdf]',
    'show_header' => 1,
    'no_key' => 1,
    'post_status' => 'private'
));
?>
<button class="btn btn-primary" onclick="window.location.href='<?php echo $laporan_pdf['url']; ?>'">Laporan Dokumen PDF</button>