<?php
global $wpdb;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$data = $wpdb->get_row("SELECT * FROM qrcode_data_dokumen WHERE id = $id");

if (!$data) {
    echo "Data tidak ditemukan";
    return;
}

$nama_ttd = $data->nama_ttd;
$kab_kota_notaris = $data->kab_kota_notaris;
$nama_notaris = $data->nama_notaris;
$kab_kot_pengesahan = $data->kab_kot_pengesahan;
$tanggal_pengesahan = $data->tanggal_pengesahan;
$tanggal_pengesahan_english = $data->tanggal_pengesahan_english;
$nomor_ahu = $data->nomor_ahu;
?>