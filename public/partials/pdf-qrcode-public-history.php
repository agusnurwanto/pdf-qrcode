<?php 
global $wpdb;

$data = $wpdb->get_results("SELECT * FROM qrcode_data_dokumen ORDER BY id DESC");
?>

<div class="container mt-4">
    <h3 class="text-center">History Dokumen</h3>

    <i class="bi bi-alarm"></i>
    <a href="?action=input" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle me-1"></i> Input Dokumen
    </a>

    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>Nama Dokumen</th>
                <th>No AHU</th>
                <th>Pengesahan</th>
                <th style="width: 200px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    
                    <!-- Nama Dokumen -->
                    <td class="text-start">
                        <?= esc_html($row->nama_notaris . ' - ' . $row->kab_kot_pengesahan); ?>
                    </td>

                    <!-- No AHU -->
                    <td class="text-center"><?= esc_html($row->nomor_ahu); ?></td>

                    <!-- Tanggal Pengesahan -->
                    <td class="text-center"><?= esc_html($row->tanggal_pengesahan); ?></td>

                    <!-- Aksi -->
                    <td class="aksi-btn">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="?action=laporan&id=<?= $row->id; ?>" class="btn btn-success btn-sm px-2 py-1" title="Lihat Sertifikat">
                                <span class="dashicons dashicons-visibility"></span>
                            </a>

                            <a href="?action=input&id=<?= $row->id; ?>" class="btn btn-warning btn-sm px-2 py-1" title="Edit">
                                <span class="dashicons dashicons-edit"></span>
                            </a>

                            <a href="?action=delete&id=<?= $row->id; ?>" class="btn btn-danger btn-sm px-2 py-1" title="Hapus" onclick="return confirm('Yakin hapus data?')">
                                <span class="dashicons dashicons-trash"></span>
                            </a>
                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>