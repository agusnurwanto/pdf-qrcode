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

	public function crb_absen_options()
	{
		global $wpdb;
		$api_key = get_option(ABSEN_APIKEY);
		if (empty($api_key)) {
			$api_key = $this->functions->generateRandomString();
			
			update_option(ABSEN_APIKEY, $api_key);
		}

		$basic_options_container = Container::make('theme_options', 'Absensi Options')
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
						' . $input_laporan_pdf . '
					</ol>
				'),
			Field::make('text', 'crb_apikey_qrcode', 'API KEY')
				->set_default_value($this->functions->generateRandomString())
				->set_help_text('Wajib diisi. API KEY digunakan untuk integrasi data.')
		];
	}

}
