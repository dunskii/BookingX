<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
global $bkx_base;
$alias_base = bkx_crud_option_multisite('bkx_alias_base');
$alias_extra = bkx_crud_option_multisite('bkx_alias_addition');
$alias_seat = bkx_crud_option_multisite('bkx_alias_seat');

$booking_url = $bkx_base->booking_page_url;
$base_id = $bkx_base->id;
$BaseObj = new BkxBase(null, $base_id);
$price_duration = bkx_get_post_price_duration_plain($bkx_base, $alias_base);
$get_seat_by_base = $BaseObj->get_seat_obj_by_base($base_id);

$BkxExtraObj = new BkxExtra();
$get_extra_by_base = $BkxExtraObj->get_extra_by_base($base_id);

$available_seats = bkx_get_post_with_price_duration($get_seat_by_base, $alias_seat);
$available_extras = bkx_get_post_with_price_duration($get_extra_by_base, $alias_extra);
$image = $desc = "yes";
if (!empty($args)) {
    $desc = $args['description'];
    $image = $args['image'];
}
$args_data = apply_filters('bkx_single_post_view_args', array('post_type' => 'bkx_base', 'ID' => $base_id) );
?>
<div class="bkx-single-post-view clearfix">
    <div class="container">
        <?php do_action('bkx_before_row_single_post', $args_data); ?>
        <div class="row">
            <?php if ($image == "yes") : ?>
                <div class="col-md-4">
                    <?php do_action('bkx_before_single_post_title', $args_data); ?>
                        <?php echo $bkx_base->get_thumb(); ?>
                    <?php do_action('bkx_after_single_post_title', $args_data); ?>
                </div>
            <?php endif; ?>
            <?php do_action('bkx_before_col_single_post', $args_data); ?>
                <div class="col-md-<?php echo ($image == "yes") ? 8 : 12; ?>">
                <div class="row">
                    <div class="col-md-8"><h1><?php echo get_the_title($base_id); ?></h1>
                        <h4><?php echo "{$price_duration['time']} {$price_duration['price']}"; ?></h4></div>
                    <div class="col-md-4">
                        <form method="post" enctype='multipart/form-data' action="<?php echo $booking_url; ?>">
                            <input type="hidden" name="type" value="bkx_base"/>
                            <input type="hidden" name="id" value="<?php echo esc_attr($base_id); ?>"/>
                            <button type="submit"
                                    class="btn btn-primary"><?php esc_html_e('Book now', 'bookingx'); ?></button>
                        </form>
                    </div>
                </div>
                <hr/>
                <?php if ($desc == "yes") : ?>
                    <div class="row">
                        <div class="col-md-12"><?php echo $BaseObj->get_description(); ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($available_seats)): ?>
                    <div class="available-services"><?php echo $available_seats; ?></div>
                <?php endif; ?>

                <?php if (!empty($available_extras)): ?>
                    <div class="available-extras"><?php echo $available_extras; ?></div>
                <?php endif; ?>
                <?php do_action('bookingx_base_meta_data', $bkx_base); ?>
            </div>
            <?php do_action('bkx_after_col_single_post', $args_data); ?>
        </div>
        <?php do_action('bkx_after_row_single_post', $args_data); ?>
    </div>
</div>