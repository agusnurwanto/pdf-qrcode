CREATE TABLE `qrcode_data_dokumen` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_ttd` varchar(225) NOT NULL,
  `kab_kota_notaris` varchar(225) NOT NULL,
  `nama_notaris` varchar(225) NOT NULL,
  `kab_kot_pengesahan` varchar(225) NOT NULL,
  `tanggal_pengesahan` varchar(225) DEFAULT NULL,
  `tanggal_pengesahan_english` varchar(225) DEFAULT NULL,
  `nomor_ahu` varchar(225) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `update_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nomor_ahu` (`nomor_ahu`),
  KEY `nama_notaris` (`nama_notaris`),
  KEY `tanggal_pengesahan` (`tanggal_pengesahan`)
);