<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $bkx_seat,$bkx_base,$bkx_addition;
if(!empty($bkx_seat)) { $bkx_current_post = $bkx_seat; }
if(!empty($bkx_base)) { $bkx_current_post = $bkx_base; }
if(!empty($bkx_addition)) { $bkx_current_post = $bkx_addition; }
?>
<div class="images col-1 service-category-active">
	<?php
		if ( has_post_thumbnail() ) {
			//$attachment_count = count( $bkx_current_post->get_gallery_attachment_ids() );
			$gallery          = $attachment_count > 0 ? '[post-gallery]' : '';
			//$props            = wc_get_post_attachment_props( get_post_thumbnail_id(), $bkx_current_post );
			$image            = get_the_post_thumbnail( $bkx_current_post->id, apply_filters( 'bkx_single_post_large_thumbnail_size', 'shop_single' ), array(
				'title'	 => get_the_title(),
				'alt'    => get_the_title(),
				'class'  => '',
			) );
			echo apply_filters(
				'bookingx_single_post_image_html',
				sprintf(
					'<a href="%s" itemprop="image" class="bookingx-main-image zoom" title="%s" data-rel="prettyPhoto%s">%s</a>',
					esc_url(get_permalink() ),
					esc_attr(get_the_title() ),
					$gallery,
					$image
				),
                $bkx_current_post->id
			);
		} else {
			echo apply_filters( 'bookingx_single_post_image_html', sprintf( '<img src="%s" alt="%s" class="" />', bkx_placeholder_img_src(), __( 'Placeholder', 'bookingx' ) ), $bkx_current_post->id );
		}

		do_action( 'bookingx_post_thumbnails' );

		 
	?>

</div>