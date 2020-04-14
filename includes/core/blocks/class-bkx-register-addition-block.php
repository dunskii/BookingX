<?php defined( 'ABSPATH' ) || exit;

class Bkx_Register_Addition_Block
{
    public $plugin_name = 'booking-x';

    public $block_name = 'bkx-addition-block';

    public function __construct() {
        add_action( 'init', array( $this,'bkx_addition_register_block_action' ) );
    }

    public function bkx_addition_register_block_action() {

        $script_slug = $this->plugin_name . '-' . $this->block_name;
        $style_slug = $this->plugin_name . '-' . $this->block_name . '-style';

        wp_enqueue_script(
            $script_slug,
            BKX_BLOCKS_ASSETS.'addition/block.js',
            [  // Dependencies that will have to be imported on the block JS file
                'wp-blocks', // Required: contains registerBlockType function that creates a block
                'wp-element', // Required: contains element function that handles HTML markup
                'wp-i18n', // contains registerBlockType function that creates a block
                'wp-server-side-render'
            ],
            BKX_PLUGIN_VER
        );

        // The block style
        // It will be loaded on the editor and on the site
        wp_register_style(
            $style_slug,
            BKX_BLOCKS_ASSETS . 'addition/css/style.css',
            ['wp-blocks'], // General style
            BKX_PLUGIN_VER
        );

        // Registering the block
        register_block_type(
            "{$this->plugin_name}/{$this->block_name}", // Block name with namespace
            [
                'style' => $style_slug, // General block style slug
                'editor_script' => $script_slug,  // The block script slug
                'render_callback' => [$this, 'bkx_additions_render_callback'],
            ]
        );
    }

    function bkx_additions_render_callback(){
        ob_start();
        echo do_shortcode('[bookingx extra-id="all"]');
        $additions_data = ob_get_clean();
        return "<div class=\"gutenberg-booking-x-additions-data\">{$additions_data}</div>";
    }
}
new Bkx_Register_Addition_Block();