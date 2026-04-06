<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Pdf_Qrcode
 * @subpackage Pdf_Qrcode/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Pdf_Qrcode
 * @subpackage Pdf_Qrcode/public
 * @author     Bakti Negara <agusnurwantomuslim@gmail.com>
 */
class Pdf_Qrcode_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	private $functions;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $functions ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->functions = $functions;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pdf_Qrcode_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pdf_Qrcode_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pdf-qrcode-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pdf_Qrcode_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pdf_Qrcode_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pdf-qrcode-public.js', array( 'jquery' ), $this->version, false );

	}

	public function input_laporan_dokumen_pdf($atts)
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once QRCODE_PLUGIN_PATH . 'public/partials/pdf-qrcode-public-input.php';
	}

	public function display_laporan_dokumen_pdf($atts)
	{
		if (isset($_GET['action'])) {

			if ($_GET['action'] == 'input') {
				require_once QRCODE_PLUGIN_PATH . 'public/partials/pdf-qrcode-public-input.php';

			} elseif ($_GET['action'] == 'view') {
				require_once QRCODE_PLUGIN_PATH . 'public/partials/pdf-qrcode-public-view.php';

			} elseif ($_GET['action'] == 'laporan') {
				require_once QRCODE_PLUGIN_PATH . 'public/partials/pdf-qrcode-public-laporan.php';

			} else {
				require_once QRCODE_PLUGIN_PATH . 'public/partials/pdf-qrcode-public-history.php';
			}

		} else {
			require_once QRCODE_PLUGIN_PATH . 'public/partials/pdf-qrcode-public-history.php';
		}
	}

	public function submit_pdf_qrcode_input()
	{
		global $wpdb;

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			wp_send_json_error(array('message' => 'Invalid request method.'));
		}

		$api_key = isset($_POST['api_key']) ? sanitize_text_field($_POST['api_key']) : '';
		
		if ($api_key !== get_option(QRCODE_APIKEY)) {
			wp_send_json_error(array('message' => 'Invalid API Key. Akses ditolak.'));
		}

		$nomor_ahu_input = isset($_POST['nomor_ahu']) ? sanitize_text_field($_POST['nomor_ahu']) : '';

		// Tambahan validasi: cek apakah nomor_ahu sudah ada di database
		if (!empty($nomor_ahu_input)) {
			$existing_data = $wpdb->get_var($wpdb->prepare(
				"SELECT COUNT(*) FROM qrcode_data_dokumen WHERE nomor_ahu = %s",
				$nomor_ahu_input
			));

			if ($existing_data > 0) {
				wp_send_json_error(array('message' => 'Gagal menyimpan: Nomor AHU sudah terdaftar dalam sistem.'));
			}
		}

		$data = array(
			'nama_ttd' => isset($_POST['nama_ttd']) ? sanitize_text_field($_POST['nama_ttd']) : '',
			'kab_kota_notaris' => isset($_POST['kab_kota_notaris']) ? sanitize_text_field($_POST['kab_kota_notaris']) : '',
			'nama_notaris' => isset($_POST['nama_notaris']) ? sanitize_text_field($_POST['nama_notaris']) : '',
			'kab_kot_pengesahan' => isset($_POST['kab_kot_pengesahan']) ? sanitize_text_field($_POST['kab_kot_pengesahan']) : '',
			'tanggal_pengesahan' => isset($_POST['tanggal_pengesahan']) ? sanitize_text_field($_POST['tanggal_pengesahan']) : '',
			'tanggal_pengesahan_english' => isset($_POST['tanggal_pengesahan_english']) ? sanitize_text_field($_POST['tanggal_pengesahan_english']) : '',
			'nomor_ahu' => $nomor_ahu_input,
		);

		$inserted = $wpdb->insert('qrcode_data_dokumen', $data);

		if ($inserted) {
			wp_send_json_success(array('message' => 'Data berhasil disimpan.'));
		} else {
			wp_send_json_error(array('message' => 'Gagal menyimpan data ke database.'));
		}
	}

	public function save_generated_pdf()
	{
		$api_key = isset($_POST['api_key']) ? sanitize_text_field($_POST['api_key']) : '';
		
		if ($api_key !== get_option(QRCODE_APIKEY)) {
			wp_send_json_error(array('message' => 'Invalid API Key. Akses ditolak.'));
		}

		if (empty($_FILES['pdf_file']) || empty($_POST['nomor_ahu'])) {
			wp_send_json_error(array('message' => 'Data tidak lengkap.'));
		}

		$nomor_ahu = sanitize_file_name($_POST['nomor_ahu']);
		$upload_dir = QRCODE_PLUGIN_PATH . 'public/dokumen/';
		
		if (!file_exists($upload_dir)) {
			wp_mkdir_p($upload_dir);
		}

		$file_path = $upload_dir . $nomor_ahu . '.pdf';
		
		if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $file_path)) {
			wp_send_json_success(array('message' => 'PDF berhasil disimpan.', 'file' => $nomor_ahu . '.pdf'));
		} else {
			wp_send_json_error(array('message' => 'Gagal menyimpan file PDF.'));
		}
	}

}
