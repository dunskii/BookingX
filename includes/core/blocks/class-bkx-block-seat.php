<?php //phpcs:ignore
/**
 * BookingX Seat Block Loader Class
 *
 * @link  https://dunskii.com
 * @since 1.0
 *
 * @package    Bookingx
 * @subpackage Bookingx/Includes/Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Bkx_Register_Seat_Block
 */
class Bkx_Register_Seat_Block extends Bkx_Block {


	/**
	 * $_instance
	 *
	 * @var null
	 */
	private static $_instance = null;

	/**
	 * $plugin_name
	 *
	 * @var string
	 */
	public $plugin_name = 'booking-x';

	/**
	 * $type
	 *
	 * @var string
	 */
	public $type = 'booking-x/bkx-seat-block';

	/**
	 * $block_name
	 *
	 * @var string
	 */
	public $block_name = 'bkx-seat-block';

	/**
	 * $script_handle
	 *
	 * @var array
	 */
	public $script_handle = array();

	/**
	 * $attributes
	 *
	 * @var string[][]
	 */
	public $attributes = array(
		'showDesc'        => array( 'type' => 'boolean' ),
		'showImage'       => array( 'type' => 'boolean' ),
		'seatDescription' => array( 'type' => 'string' ),
		'seatImageStatus' => array( 'type' => 'string' ),
		'orderBy'         => array( 'type' => 'string' ),
		'order'           => array( 'type' => 'string' ),
		'seatPostId'      => array( 'type' => 'string' ),
		'seatPosts'       => array( 'type' => 'object' ),
		'columns'         => array( 'type' => 'integer' ),
		'rows'            => array( 'type' => 'integer' ),

	);

	/**
	 * Block get_instance
	 *
	 * @return Bkx_Register_Seat_Block|null
	 */
	public static function get_instance() {
		if ( null === self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	/**
	 * Block getScripts
	 *
	 * @return array|array[]
	 */
	public function getScripts() : array {
		$script_slug         = $this->plugin_name . '-' . $this->block_name;
		$min                 = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$bootstrap_script    = $this->plugin_name . '-' . $this->type . '-bootstrap-script';
		$this->script_handle = array( $script_slug, $bootstrap_script );
		$seat_alias          = bkx_crud_option_multisite( 'bkx_alias_seat' );
		$base_alias          = bkx_crud_option_multisite( 'bkx_alias_base' );
		$extra_alias         = bkx_crud_option_multisite( 'bkx_alias_addition' );
		return array(
			array(
				'handle'    => $script_slug,
				'src'       => BKX_BLOCKS_ASSETS . 'seat/block.js',
				'deps'      => array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-i18n', 'wp-editor' ),
				'version'   => $min ? BKX_PLUGIN_VER : filemtime( BKX_BLOCKS_ASSETS_BASE_PATH . '/seat/block.js' ),
				'callback'  => array(),
				'localized' => array(
					'site_url' => get_site_url(),
					's_alias'  => $seat_alias,
					'b_alias'  => $base_alias,
					'e_alias'  => $extra_alias,
				),
			),
			array(
				'handle'   => $bootstrap_script,
				'src'      => BKX_PLUGIN_PUBLIC_URL . '/js/booking-form/bootstrap.min.js',
				'deps'     => array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-i18n', 'wp-editor' ),
				'version'  => $min ? BKX_PLUGIN_VER : filemtime( BKX_PLUGIN_PUBLIC_PATH . '\js/booking-form/bootstrap.min.js' ),
				'callback' => array(),
			),
		);
	}

	/**
	 * Block getStyles
	 *
	 * @return array|array[]
	 */
	public function getStyles() : array {
		$deps            = array( 'wp-edit-blocks' );
		$bootstrap_style = $this->plugin_name . '-' . $this->type . '-bootstrap-style';
		$style_main      = $this->plugin_name . '-' . $this->type . '-style-main';
		$style_slug      = $this->plugin_name . '-' . $this->type . '-style-block';

		return array(
			array(
				'handle'  => $style_slug,
				'src'     => BKX_BLOCKS_ASSETS . 'seat/css/style.css',
				'deps'    => $deps,
				'version' => defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? filemtime( BKX_BLOCKS_ASSETS_BASE_PATH . '/seat/css/style.css' ) : BKX_PLUGIN_VER,
			),
			array(
				'handle'  => $style_main,
				'src'     => BKX_PLUGIN_PUBLIC_URL . '/css/style.css',
				'deps'    => $deps,
				'version' => defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? filemtime( BKX_PLUGIN_DIR_PATH . '\public/css/style.css' ) : BKX_PLUGIN_VER,
			),
			array(
				'handle'  => $bootstrap_style,
				'src'     => BKX_PLUGIN_PUBLIC_URL . '/css/bootstrap.min.css',
				'deps'    => $deps,
				'version' => defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? filemtime( BKX_PLUGIN_DIR_PATH . '\public/css/bootstrap.min.css' ) : BKX_PLUGIN_VER,
			),
		);
	}

	/**
	 * Block render_block
	 *
	 * @param  $attributes
	 * @return string
	 */
	function render_block( $attributes = array() ): string {
		// Prepare variables.
		$desc       = isset( $attributes['seatDescription'] ) && '' !== $attributes['seatDescription'] ? $attributes['seatDescription'] : 'yes';
		$image      = isset( $attributes['seatImageStatus'] ) && '' !== $attributes['seatImageStatus'] ? $attributes['seatImageStatus'] : 'yes';
		$order_by   = isset( $attributes['orderBy'] ) ? $attributes['orderBy'] : 'ID';
		$order_type = isset( $attributes['order'] ) ? $attributes['order'] : 'ASC';
		$seat_id    = isset( $attributes['seatPostId'] ) && $attributes['seatPostId'] > 0 ? $attributes['seatPostId'] : 'all';
		$columns    = isset( $attributes['columns'] ) ? $attributes['columns'] : 3;
		$rows       = isset( $attributes['rows'] ) ? $attributes['rows'] : 1;
		ob_start();
		echo do_shortcode( '[bookingx block="1" order="' . $order_type . '" order-by="' . $order_by . '" seat-id="' . $seat_id . '" columns="' . $columns . '" rows="' . $rows . '"  description="' . $desc . '" image="' . $image . '"]' );
		$seats_data = ob_get_clean();
		return "<div class=\"gutenberg-booking-x-seats-data\">{$seats_data}</div>";
	}
}

// Register block.
// phpcs:disable
if ( true !== ( $registered = Bkx_Blocks::register( Bkx_Register_Seat_Block::get_instance() ) ) && is_wp_error( $registered ) ) { // phpcs: ignore
	// Log that block could not be registered.
	echo '<pre>', print_r( esc_html( $registered->get_error_message() ), 1 ), '</pre>';
}
