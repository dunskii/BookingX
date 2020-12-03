<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $bkx_seat;

$booking_url = $bkx_seat->booking_page_url;
$seat_id = $bkx_seat->id;
$BaseObj = new BkxBase();
$get_base_by_seat = $BaseObj->get_base_by_seat(get_the_ID());

$BkxExtraObj = new BkxExtra();
$get_extra_by_seat = $BkxExtraObj->get_extra_by_seat($get_base_by_seat);

$alias_base = bkx_crud_option_multisite('bkx_alias_base');
$alias_extra = bkx_crud_option_multisite('bkx_alias_addition');
$available_services = bkx_get_post_with_price_duration($get_base_by_seat, $alias_base);
$available_extras = bkx_get_post_with_price_duration($get_extra_by_seat, $alias_extra);

$personal_info = $bkx_seat->seat_personal_info;
$seat_available_months = $bkx_seat->seat_available_months;
$seat_available_days = $bkx_seat->seat_available_days;
$seat_notifiaction_info = $bkx_seat->seat_notifiaction_info;
$seat_payment_info = $bkx_seat->seat_payment_info;
$seat_address = $bkx_seat->seat_address();
$image = $desc = "yes";
if (!empty($args)) {
    $desc = $args['description'];
    $image = $args['image'];
}
$args_data = apply_filters('bkx_single_post_view_args', array('post_type' => 'bkx_seat', 'ID' => $seat_id) );
?>
<div class="bkx-single-post-view clearfix">
    <div class="container">
        <?php do_action('bkx_before_row_single_post', $args_data); ?>
        <div class="row">
            <?php if ($image == "yes") : ?>
                <div class="col-md-4">
                    <?php do_action('bkx_before_single_post_title', $args_data); ?>
                        <?php echo $bkx_seat->get_thumb(); ?>
                    <?php do_action('bkx_after_single_post_title', $args_data); ?>
                </div>
            <?php endif; ?>
            <?php do_action('bkx_before_col_single_post', $args_data); ?>
            <div class="col-md-<?php echo ($image == "yes") ? 8 : 12; ?>">
                <div class="row">
                    <div class="col-md-8"><h1><?php echo get_the_title($seat_id); ?></h1></div>
                    <div class="col-md-4">
                        <div class="booking-btn">
                            <form method="post" enctype='multipart/form-data' action="<?php echo $booking_url; ?>">
                                <input type="hidden" name="type" value="bkx_seat"/>
                                <input type="hidden" name="id" value="<?php echo esc_attr($seat_id); ?>"/>
                                <button type="submit"
                                        class="btn btn-primary"><?php esc_html_e('Book now', 'bookingx'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr/>
                <?php if ($desc == "yes") : ?>
                    <div class="row">
                        <div class="col-md-12"><?php echo apply_filters('the_content', get_the_content('',false,$bkx_seat->post)); ?></div>
                    </div>
                <?php endif; ?>

	            <?php if (!empty($seat_address)): ?>
                    <div class="seat-address"><?php echo $seat_address; ?></div>
	            <?php endif; ?>

                <?php if (!empty($available_services)): ?>
                    <div class="available-services"><?php echo $available_services; ?></div>
                <?php endif; ?>

                <?php if (!empty($available_extras)): ?>
                    <div class="available-extras"><?php echo $available_extras; ?></div>
                <?php endif; ?>

                <?php if (!empty($seat_available_months) || !empty($seat_available_days) || !empty($seat_payment_info)): ?>
                    <div class="meta-data businessHours"><?php bkx_get_template('bkx-single/meta/seat.php'); ?></div>
                <?php endif; ?>

                <?php do_action('bkx_seat_addition_info', $seat_id); ?>
            </div>
            <?php do_action('bkx_after_col_single_post', $args_data); ?>
        </div>
        <?php do_action('bkx_after_row_single_post', $args_data); ?>
    </div>
</div>