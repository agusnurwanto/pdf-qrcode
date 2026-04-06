<?php
global $wpdb;

$data = $wpdb->get_results("SELECT * FROM qrcode_data_dokumen ORDER BY id DESC");
?>

<div class="container mt-4">
    <h3>History Dokumen</h3>

    <a href="?action=input" class="btn btn-primary mb-3">+ Input Dokumen</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Dokumen</th>
                <th>No AHU</th>
                <th>Pengesahan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= esc_html($row->nama_ttd); ?></td>
                    <td><?= esc_html($row->nomor_ahu); ?></td>

                    <td>
                        <a href="?action=laporan&id=<?= $row->id; ?>" class="btn btn-success btn-sm">
                            Lihat Sertifikat
                        </a>
                    </td>
                    <td>
                        <a href="?action=view&id=<?= $row->id; ?>" class="btn btn-info btn-sm" title="View">
                            <span class="dashicons dashicons-visibility"></span>
                        </a>

                        <a href="?action=input&id=<?= $row->id; ?>" class="btn btn-warning btn-sm" title="Edit">
                            <span class="dashicons dashicons-edit"></span>
                        </a>

                        <a href="?action=delete&id=<?= $row->id; ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin hapus data?')">
                            <span class="dashicons dashicons-trash"></span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>