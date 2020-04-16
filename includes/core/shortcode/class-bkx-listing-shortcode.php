<?php
/**
 * Listing ShortCodes for Seat, Base and Extra Services
 *
 * @package Bookingx/Core/Classes
 */

defined( 'ABSPATH' ) || exit;
class BKX_Listing_ShortCodes
{
    private static $post_type = array();

    public static function init() {
        add_shortcode( 'bookingx', array( __CLASS__, 'bookingx_shortcode_callback' ) );
        self::$post_type = array('bkx_seat', 'bkx_base', 'bkx_addition');
    }

    public function bookingx_shortcode_callback( $atts ){
        if(!empty($atts)){
            $post_type = self::find_post_type($atts);
            $seat_id = isset( $atts['seat-id'] ) && $atts['seat-id'] > 0 ? $atts['seat-id'] : 0;
            $class = "";
            if($seat_id > 0 ){
                $query = new WP_Query( array( 'post_type' => $post_type, 'post__in' => array($seat_id)) );
            }else{
                $query = new WP_Query( array( 'post_type' => $post_type) );
                $class = "booking-x-lists";
            }
            ob_start();
            if ($query->have_posts()) :?>
            <div class="container <?php echo $class;?>">
                <div class="row">
                    <?php while ( $query->have_posts() ) : $query->the_post();
                        if($seat_id > 0 ){
                            bkx_get_template("content-single-{$post_type}.php", $atts);
                        }else{
                            bkx_get_template("content-{$post_type}.php", $atts);
                        }
                    endwhile;?>
                </div>
            </div>
            <?php
            else:
                do_action("bookingx_no_{$post_type}_found");
            endif;
            return ob_get_clean();
        }
    }

    public function find_post_type( $atts ){
        if(empty($atts))
            return;
        $find_archive = array('seat-id' => 'bkx_seat', 'base-id' => 'bkx_base', 'extra-id' => 'bkx_addition');
        foreach ($find_archive as $key => $data ){
            if (array_key_exists($key, $atts)){
                return $find_archive[$key];
            }
        }
    }
}
add_action( 'init', array( 'BKX_Listing_ShortCodes', 'init' ) );