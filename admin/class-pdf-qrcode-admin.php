<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Pdf_Qrcode
 * @subpackage Pdf_Qrcode/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pdf_Qrcode
 * @subpackage Pdf_Qrcode/admin
 * @author     Bakti Negara <agusnurwantomuslim@gmail.com>
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;
class Pdf_Qrcode_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $functions ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->functions = $functions;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pdf-qrcode-admin.css', array(), $this->version, 'all' );
		// Bootstrap Icons CDN
		wp_enqueue_style(
			'bootstrap-icons',
			'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
			array(),
			null
		);
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pdf-qrcode-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function crb_qrcode_options()
	{
		global $wpdb;
		$api_key = get_option(QRCODE_APIKEY);
		if (empty($api_key)) {
			$api_key = $this->functions->generateRandomString();
			
			update_option(QRCODE_APIKEY, $api_key);
		}

		$basic_options_container = Container::make('theme_options', 'QRCODE Options')
			->set_page_menu_position(3)
			->add_tab('⚙️ Konfigurasi Umum', $this->generate_fields_options_konfigurasi_umum());
	}

	public function generate_fields_options_konfigurasi_umum()
	{
		$input_laporan_pdf = $this->functions->generatePage(array(
			'nama_page' => 'Input Laporan Dokumen PDF',
			'content' => '[input_laporan_dokumen_pdf]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));

		return [
			Field::make('html', 'crb_tahun_list')
				->set_html('
					<h5>DAFTAR TAHUN</h5>
					<ol id="list-tahun">
						<li><a target="_blank" href="' . $input_laporan_pdf['url'] . '">' . $input_laporan_pdf['title'] . '</a></li>
					</ol>
				'),
			Field::make('text', 'crb_apikey_qrcode', 'API KEY')
				->set_default_value($this->functions->generateRandomString())
				->set_help_text('Wajib diisi. API KEY digunakan untuk integrasi data.'),
			Field::make('html', 'crb_sql_migrate')
				->set_html('
					<div style="margin-top: 15px;">
						<button type="button" id="btn-sql-migrate" class="button button-primary" style="margin-bottom: 5px;">Migrate SQL</button>
						<p id="sql-migrate-msg" style="margin: 0; font-weight: bold;"></p>
					</div>
				')
		];
	}

	public function migrate_sql() {
		global $wpdb;
		$sql_file = plugin_dir_path(dirname(__FILE__)) . 'table.sql';
		
		if (file_exists($sql_file)) {
			$sql = file_get_contents($sql_file);
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			
			wp_send_json_success(array('message' => 'Tabel berhasil dibuat atau diperbarui.'));
		} else {
			wp_send_json_error(array('message' => 'File table.sql tidak ditemukan.'));
		}
	}

}
