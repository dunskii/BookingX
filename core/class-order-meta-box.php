<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Bkx_Meta_Boxes {


	public $post_type = 'bkx_booking';

	protected static $billing_fields = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'remove_meta_boxes' ), 10 );
		add_action( 'add_meta_boxes', array( $this, 'rename_meta_boxes' ), 20 );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ), 1, 2 );
	}

		/**
	 * Add WC Meta boxes.
	 */
	public function add_meta_boxes() {

		global $post;

		// Orders
			$order_type_object = get_post_type_object( $this->post_type );

			$order_id = get_post_meta( $post->ID, 'order_id', true);
			add_meta_box( 'bkx-general-data', sprintf( __( '%s Data', 'bookingx' ), $order_type_object->labels->singular_name ),
			array( $this, 'bookingx_output' ), $this->post_type, 'normal', 'high' );

			if(isset($order_id) && $order_id!= ''){
				add_meta_box( 'bkx-order_note', sprintf( __( '%s #%s Notes', 'bookingx' ), $order_type_object->labels->singular_name, $post->ID ),array( $this, 'bookingx_note_output' ), $this->post_type, 'side', 'high' );
			}
			add_meta_box( 'bkx-order_reassign', sprintf( __( '%s Reassign', 'bookingx' ), $order_type_object->labels->singular_name ),array( $this, 'bookingx_reassign_output' ), $this->post_type, 'side' );
		
	}

	/**
	 * Rename core meta boxes.
	 */
	public function rename_meta_boxes() {
		global $post;

		// Comments/Reviews
		if ( isset( $post ) && ( 'publish' == $post->post_status || 'private' == $post->post_status ) ) {
			remove_meta_box( 'commentsdiv', 'product', 'normal' );

			add_meta_box( 'commentsdiv', __( 'Reviews', 'Bookingx' ), 'post_comment_meta_box', 'product', 'normal' );
		}
	}


		/**
	 * Remove bloat.
	 */
	public function remove_meta_boxes() {
		
		remove_meta_box( 'commentsdiv', $this->post_type, 'normal' );
		remove_meta_box( 'commentstatusdiv', $this->post_type, 'normal' );
		remove_meta_box( 'slugdiv', $this->post_type, 'normal' );
		remove_meta_box( 'submitdiv', $this->post_type, 'side' );
	
	
	}

	public function bookingx_output( $post, $return_type = null )
	{	
		global $_wp_admin_css_colors; $admin_colors = $_wp_admin_css_colors;
		$order_summary = "";
		$current_color = get_user_option( 'admin_color' );
		$main_obj = $admin_colors[$current_color];

		$colors = $admin_colors[$current_color]->colors;
		$icon_colors = $admin_colors[$current_color]->icon_colors;
		 
		$orderObj =  new BkxBooking();
    	$order_meta = $orderObj->get_order_meta_data($post->ID);

    	$base_extended = get_post_meta($post->ID, 'extended_base_time', true);
        $base_extended = ($base_extended) ? $base_extended : 0 ;

    	$order_id = $post->ID;
    	//print_r($order_meta );
		$order_type_object = get_post_type_object( $post->post_type );
		wp_nonce_field( 'bookingx_save_data', 'bookingx_meta_nonce' );
		//$set_height = empty($order_meta['seat_id']) ? 'auto' : '510px';
		$set_height = empty($order_meta['seat_id']) ? 'auto' : 'auto';
 
		if($main_obj->name == 'Default' || $main_obj->name == 'Coffee' || $main_obj->name == 'Midnight' || $main_obj->name =='Ectoplasm'){
			$time_text = '#fff;';
		}else
		{
			$time_text = 'inherit;';
		}

		//if($return_type == ''){ 
?>			<style type="text/css">
			#date_time_display {color: <?php echo $time_text;?>}
			#post-body-content, #titlediv { display:none }
			.bkx-general_full { float: left;width: 32%;}
			.bkx-order_summary_full{background: #fff; min-height: <?php echo $set_height; ?>;}
			.base_timeline{width: 204px;background: red; float: left;}
			.seat_rectangle{font-size:12px;}
			#bkx_progressbar_wrapper_4 .ui-widget-header { background: <?php echo $colors[0];?> !important;}
			#id_datepicker .ui-widget-content {border: 1px solid #e5e5e5 !important;}
			#id_datepicker .ui-state-default {background: #ffffff !important;}
			#id_datepicker .ui-state-active { background: <?php echo $colors[1];?> !important; color: <?php echo $time_text;?>; }
			.booking-status-booked{ background-color:<?php echo $colors[3];?> !important;}
			.booking-status-open{ background-color:<?php echo $colors[1];?> !important; }
			.free { background:<?php echo $colors[1];?> !important;}
			.selected-slot{background:<?php echo $colors[2];?> !important;}
			.full { background:<?php echo $colors[3];?> !important; }
			.seat_rectangle { background-color:<?php echo $colors[1];?> !important;}
			#div1 { background-color:<?php echo $colors[2];?> !important;}
			.booking-status-current{ background-color:<?php echo $colors[2];?>!important; }
			</style>
		 <?php
		 // if(empty($order_meta['seat_id'])){
		 //  echo do_shortcode('[bookingform order_post_id='.$post->ID.']');
		 //  return;
		 // }
		 //print_r($order_meta);
		$extra_id = get_post_meta( $post->ID, 'addition_ids', true );
		$extra_id = rtrim( $extra_id, ",");
		$booking_start_date = date('m/d/Y',strtotime($order_meta['booking_start_date']));
		$alias_seat = bkx_crud_option_multisite('bkx_alias_seat');
		$alias_base = bkx_crud_option_multisite('bkx_alias_base');
		$alias_extra = bkx_crud_option_multisite('bkx_alias_addition');

        $seat_alias = bkx_crud_option_multisite('bkx_alias_seat');      
    	$base_alias = bkx_crud_option_multisite('bkx_alias_base');
    	$addition_alias = bkx_crud_option_multisite('bkx_alias_addition');
		
		$payment_status ='';
		$check_total_payment =0;
		$payment_meta = get_post_meta($order_id,'payment_meta',true);
		if(!empty($payment_meta) && is_array($payment_meta))
		{
			$payment_status = $payment_meta['payment_status'];
			$check_total_payment = $payment_meta['pay_amt'];
		}
    	$payment_status = ($payment_status) ? $payment_status : 'Pending';
		$seat_base_edit_mode = 0 ;
		if($payment_status == 'Completed'){
			$seat_base_edit_mode = 1;
		}	   

		if(isset($check_total_payment) && $check_total_payment !='' && $check_total_payment != 0){
    		$check_remaining_payment = $order_meta['total_price'] - $check_total_payment;
    	}

    	 
        $search['search_by'] = 'future';
        $search['search_date'] = date('Y-m-d');

        $booked_days = '';
        $BookedRecords = $orderObj->GetBookedRecordsByUser($search);

        if (!empty($BookedRecords)) {
            foreach ($BookedRecords as $bookings) :

            	if(isset($bookings['booking_multi_days']) && !empty($bookings['booking_multi_days'])) :
	                $booking_multi_days = $bookings['booking_multi_days'];
	                $booking_multi_days_arr = explode(",", $booking_multi_days);
	                if (!empty($booking_multi_days_arr)) {
	                    $booking_multi_days_data = !empty($booking_multi_days_arr[0]) ? $booking_multi_days_arr[0] : "";
	                    $booking_multi_days_data_1 = !empty($booking_multi_days_arr[1]) ? $booking_multi_days_arr[1] : "";
	                    $booking_multi_days_range = bkx_getDatesFromRange($booking_multi_days_data, $booking_multi_days_data_1, "m/d/Y");
	                    if (!empty($booking_multi_days_range)) {
	                        foreach ($booking_multi_days_range as $multi_days) {
	                            $booked_days .= $multi_days . ",";
	                        }
	                    }
	                }
            	endif;

                $booking_start_date = date('m/d/Y', strtotime($bookings['booking_start_date']));
                $booked_days .= $booking_start_date . ",";
            endforeach;
            $booked_days = rtrim($booked_days, ',');
        } else {
            $booked_days = 0;
        }
        $booked_days_arr = explode(",", $booked_days);
        $booked_days_filtered = implode(",", array_unique($booked_days_arr));

        $bkx_biz_vac_sd = bkx_crud_option_multisite('bkx_biz_vac_sd');
        $bkx_biz_vac_ed = bkx_crud_option_multisite('bkx_biz_vac_ed');
        $bkx_biz_pub_holiday = bkx_crud_option_multisite('bkx_biz_pub_holiday');
        $biz_pub_days = '';
        $bkx_biz_pub_holiday = array_values($bkx_biz_pub_holiday);
        if (!empty($bkx_biz_pub_holiday)) {
            foreach ($bkx_biz_pub_holiday as $key => $bkx_biz_pub_holiday_day) {
                if(isset($bkx_biz_pub_holiday_day) && $bkx_biz_pub_holiday_day!=""){
                    $pub_hd_obj = DateTime::createFromFormat('d/m/Y', $bkx_biz_pub_holiday_day);
                    $final_bkx_biz_pub_holiday_day[] = $pub_hd_obj->format('m/d/Y');
                }
            }
            if(!empty($final_bkx_biz_pub_holiday_day)){
                $biz_pub_days = implode(",", $final_bkx_biz_pub_holiday_day);
            }
        }
        $biz_vac_days = "";
        if (!empty($bkx_biz_vac_sd) && !empty($bkx_biz_vac_ed)) {
            $biz_vac_days = bkx_getDatesFromRange($bkx_biz_vac_sd, $bkx_biz_vac_ed, "m/d/Y");
            if (!empty($biz_vac_days)) {
                $biz_vac_days = implode(",", $biz_vac_days);
            }
        }
			if(!empty($order_meta) ):
					$translation_array = array('order_id' => $post->ID,
												'seat_id' => $order_meta['seat_id'],
												'base_id' => $order_meta['base_id'],
												'extra_id' => !empty($extra_id) ? $extra_id : '0',
												'extended' => $base_extended,
												'booking_start_date' => $booking_start_date,
												'seat_base_edit_mode' => $seat_base_edit_mode,
												'booked_days' => $booked_days_filtered,
									            'biz_vac_days' => $biz_vac_days,
									            'biz_pub_days' => $biz_pub_days,
									            'step_text' => sprintf(__('%s','bookingx'), 'Step'),
									            'step_text_of' => sprintf(__('%s','bookingx'), 'of'),
									            'select_a_text'     => sprintf(__('%s','bookingx'), 'Select a'),
									            'total_cost'     => sprintf(__('%s','bookingx'), 'Total Cost'),
									            'total_tax'     => sprintf(__('%s','bookingx'), 'Total Tax'),
									            'note'     => sprintf(__('%s','bookingx'), 'Note'),
									            'date_time'     => sprintf(__('%s','bookingx'), 'Date / Time'),
									            'grand_total'     => sprintf(__('%s','bookingx'), 'Grand Total'),
												'action' => 'edit');
			else:
				$translation_array = array('order_id' => '',
												'seat_id' => '',
												'base_id' => '',
												'extra_id' => 0,
												'extended' => $base_extended,
												'seat_alias' => $alias_seat,
												'base_alias' => $alias_base,
												'extra_alias' => $alias_extra,
												'seat_base_edit_mode' => $seat_base_edit_mode,
												'booked_days' => $booked_days_filtered,
									            'biz_vac_days' => $biz_vac_days,
									            'biz_pub_days' => $biz_pub_days,
									            'step_text' => sprintf(__('%s','bookingx'), 'Step'),
									            'step_text_of' => sprintf(__('%s','bookingx'), 'of'),
									            'select_a_text'     => sprintf(__('%s','bookingx'), 'Select a'),
									            'total_cost'     => sprintf(__('%s','bookingx'), 'Total Cost'),
									            'total_tax'     => sprintf(__('%s','bookingx'), 'Total Tax'),
									            'note'     => sprintf(__('%s','bookingx'), 'Note'),
									            'date_time'     => sprintf(__('%s','bookingx'), 'Date / Time'),
									            'grand_total'     => sprintf(__('%s','bookingx'), 'Grand Total'),
												'action' => 'add');
			endif;
			$validation_array = bkx_localize_string_text();
        	$wp_localize_array = array_merge($translation_array,$validation_array);
			wp_localize_script('common_script', 'edit_order_data', $wp_localize_array);
			
			 	
			//print_r($order_meta['extra_arr']);
	    	$extra_data = sprintf( __('<p>%s service\'s :','Bookingx'),$addition_alias);
	    	if(!empty($order_meta['extra_arr'])){
	    		foreach ($order_meta['extra_arr'] as $key => $extra_arr) {
	    			$extra_data .=  sprintf(__('&nbsp;<a href="%s" target="_blank">%s</a>&nbsp;','Bookingx'),$extra_arr['permalink'],$extra_arr['title'],$extra_arr['title']);
	    		}	
	    	}
	    if(isset($order_meta['seat_id']) && $order_meta['seat_id']!=''){

		$order_summary = sprintf('<div class="bkx-order_summary_full">','Bookingx');
		$order_summary .= sprintf( __('<h3>Booking #%d details</h3>','Bookingx'),$post->ID);
		$order_summary .= sprintf('<div class="bkx-general_full">','Bookingx');
		//$order_summary .= sprintf( __('<h4>Customer Information</h4>','Bookingx'));
		$order_summary .= sprintf( __('<p>Full Name : <span id="bkx_fname"> %s </span><span id="bkx_lname"> %s </span></p>','Bookingx'),$order_meta['first_name'],$order_meta['last_name']);
		$order_summary .= sprintf( __('<p>Phone : <a href="callto:%s" id="bkx_phone"><span id="bkx_phone">%s</span></a></p>','Bookingx'),$order_meta['phone'],$order_meta['phone']);
		$order_summary .= sprintf( __('<p>Email : <a href="mailto:%s" id="bkx_email"><span id="bkx_email">%s</span></a></p>','Bookingx'),$order_meta['email'],$order_meta['email']);
		$order_summary .= sprintf( __('<p>Address : <span id="bkx_address"> %s %s </span></p>','Bookingx'),$order_meta['city'],$order_meta['state']);
		$order_summary .= sprintf( __('<p>Postcode : <span id="bkx_postcode"> %s </span> </p>','Bookingx'),$order_meta['postcode']);
		$order_summary .= sprintf('</div>','Bookingx');

		$order_summary .= sprintf('<div class="bkx-general_full">','Bookingx');
		//$order_summary .= sprintf( __('<h4>Booking Details</h4>','Bookingx'));
		$order_summary .= sprintf(__('<p>Booking Date : <span id="bkx_booking_date">%s </span> </p>','Bookingx'),$order_meta['booking_start_date']);
		$order_summary .= sprintf(__('<p> Time : <span id="bkx_booking_time">%s </span> </p>','Bookingx'),$order_meta['total_duration']);
		$order_summary .= sprintf(__('<p>Status : <span id="bkx_booking_status">%s </span> </p>','Bookingx'),$orderObj->get_order_status($post->ID));
		$order_summary .= sprintf(__('<p>Total : %s<span id="bkx_booking_total">%s </span> </p> </p>','Bookingx'),bkx_get_current_currency(),$order_meta['total_price']);
 
			$order_summary .= sprintf(__('<p id="bkx_payment_status">Payment : %s </p>','Bookingx'),$payment_status); 
			if($payment_status == 'Completed'){
				$order_summary .= sprintf(__('<p>Token : %s </p>','Bookingx'),$payment_meta['token']);
				$order_summary .= sprintf(__('<p>PayerID Id : %s </p>','Bookingx'),$payment_meta['PayerID']); 
				$order_summary .= sprintf(__('<p>Transaction Id : %s </p>','Bookingx'),$payment_meta['transactionID']);
				if(isset($check_remaining_payment) && $check_remaining_payment != 0 && $check_remaining_payment != ''){
					$order_summary .= sprintf(__('<p> <b> Note : %s%s %s  </b> </p>','Bookingx'),bkx_get_current_currency(),$check_remaining_payment,'payment will be made when the customer comes for the booking');
				}
			}
			else
			{
				$order_summary .= sprintf(__('<p> Note  : %s </p>','Bookingx'),"payment will be made when the customer comes for the booking");
			}
		$order_summary .= sprintf('</div>','Bookingx');
		$extra_data = sprintf( __('<p id="bkx_extra_name">%s service\'s :','Bookingx'),$addition_alias);
		$extra_data .='<span id="bkx_extra_data">';
    	if(!empty($order_meta['extra_arr'])){
    		foreach ($order_meta['extra_arr'] as $key => $extra_arr) {
    			$extra_data .=  sprintf(__('&nbsp;<a href="%s" target="_blank">%s</a>&nbsp;','Bookingx'),$extra_arr['permalink'],$extra_arr['title'],$extra_arr['title']);
    		}	
    	}
    	else
    	{
    		$extra_data .= sprintf('&nbsp;None','Bookingx');
    	}
    	$extra_data .='</span>';
	    $order_summary .= sprintf('<div class="bkx-general_full">','Bookingx');
 
		$order_summary .= sprintf(__('<p id="bkx_seat_name">%s Name : <a href="%s" title="%s">%s</a></p>','Bookingx'),$seat_alias,$order_meta['seat_arr']['permalink'],$order_meta['seat_arr']['title'],$order_meta['seat_arr']['title']);
		$order_summary .= sprintf(__('<p id="bkx_base_name">%s Name : <a href="%s">%s</a> </p>','Bookingx'),$base_alias,$order_meta['base_arr']['permalink'],$order_meta['base_arr']['title'],$order_meta['base_arr']['title']);
		$order_summary .= $extra_data;
		$order_summary .= sprintf('</div>','Bookingx');
 	 
		$order_summary .= sprintf('<div style="clear:left;">&nbsp;</div>','Bookingx');
		
		 if(!empty($order_meta['seat_id'])){
		 // 	$order_summary .='<div class="bkx-general_full" style="width: 100%;"><div id="seat_rect_'.$post->ID.'" class="seat_rectangle" style="padding: 5px;min-height: 150px;height:auto;width: 100%;border:1px solid #62A636;float:left">
			// </div></div>';
		 } 
		

		$order_summary .= sprintf('</div>','Bookingx');

		}
 		if($return_type == 'ajax'){
 			return $order_summary;
 		}
		echo $order_summary;
		echo '<div style="clear:left;">&nbsp;</div>';
		echo do_shortcode('[bookingform order_post_id='.$post->ID.']');

		//}	
	}


	public function bookingx_note_output( $post, $return_type = null )
	{
		$orderObj =  new BkxBooking();
		$order_meta = $orderObj->get_order_meta_data($post->ID);

		if(empty($order_meta['seat_id'])){
		  echo '<style>#bkx-order_summary { display : none; };</style>';
		  return;
		}
		$script = '<script type="text/javascript"> jQuery(document).ready(function(){ jQuery( "#bkx_id_add_custom_note" ).on( "click", function() {
		jQuery("#bkx_add_custom_note_loader").show();
		jQuery("#bkx_id_add_custom_note").hide();
		
		var booking_id = jQuery( "#bkx_booking_id" ).val();
		var bkx_custom_note = jQuery( "#bkx_custom_note" ).val();
		if(bkx_custom_note == "")
		{
			jQuery("#bkx_add_custom_note_err").html("Please add note.");
			jQuery("#bkx_add_custom_note_loader").hide();
			jQuery("#bkx_id_add_custom_note").show();
			return false;
		}

		if(confirm("Are you sure want to add note?"))
		{
			jQuery("#bkx_add_custom_note_err").hide();
			var data = {
	            "action": "bkx_action_add_custom_note",
	            "bkx_custom_note": bkx_custom_note,
	            "booking_id" : booking_id
	        };

	        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	        jQuery.post(ajaxurl, data, function(response) {
	        	jQuery("#bkx_add_custom_note_loader").hide();
	        	jQuery("#bkx_id_add_custom_note").hide();
	             location.reload();
	        });

		}		
	});});</script>';
		$seat_alias = bkx_crud_option_multisite('bkx_alias_seat');      
    	$base_alias = bkx_crud_option_multisite('bkx_alias_base');
    	$addition_alias = bkx_crud_option_multisite('bkx_alias_addition');

		$order_summary 	= sprintf('<div class="bkx-order_summary">','Bookingx');
		$order_summary .= sprintf( __('<h3>Booking #%d Notes</h3>','Bookingx'),$post->ID);
		$order_summary .= sprintf( __('<span id="bkx_add_custom_note_err"></span><textarea rows="4" id="bkx_custom_note"></textarea>','Bookingx'), '');
		$order_summary .= sprintf( __('<input type="hidden" id="bkx_booking_id" value="%d">','Bookingx'),$post->ID);
		
		$order_summary .= sprintf( __('<a style="cursor:pointer;" id="bkx_id_add_custom_note" name="bkx_add_custom_note"> Add note </a> <span id="bkx_add_custom_note_loader" style="display:none;"> Please wait.. </span>','Bookingx'), '');
		$order_summary .= $orderObj->get_booking_notes($post->ID);
		$order_summary .= sprintf('</div>','Bookingx');
		$order_summary .= $script;
		

		if($return_type == 'ajax'){
 				return $order_summary;
 		}
		echo $order_summary;

	}


	public function bookingx_reassign_output( $post, $return_type = null  )
	{
		$seat_alias = bkx_crud_option_multisite('bkx_alias_seat'); 

		$orderObj =  new BkxBooking();
		$order_meta = $orderObj->get_order_meta_data($post->ID);

		if(empty($order_meta['seat_id'])){
		  echo '<style>#bkx-order_reassign { display : none; };</style>';
		  return;
		 }

		$reassign_booking = '';

		$reassign_booking .=  sprintf(__('<div class="bkx-order_summary"><p>Current %s assign : <a href="%s" title="%s">%s</a></p>','Bookingx'),
			$seat_alias,$order_meta['seat_arr']['permalink'],
			$order_meta['seat_arr']['title'],
			$order_meta['seat_arr']['title']);

		$source = $order_meta['booking_start_date'];
		$date = new DateTime($source);
		$booking_start_date = addslashes($date->format('m/d/Y'));
		$start_time = addslashes($date->format('H:i:s'));
		$order_start_date = isset($order_meta['start_date']) ? $order_meta['start_date'] : "";
		$order_end_date = isset($order_meta['end_date']) ? $order_meta['end_date'] : "";
		$order_base_id  = isset($order_meta['base_id']) ? $order_meta['base_id'] : "";
		$get_available_staff = bkx_reassign_available_emp_list($order_meta['seat_id'],$order_start_date,$order_end_date,$order_base_id);
		$reassign_booking .= '<b>Reassign '.$seat_alias.' to booking: </b>
			 <select id="id_reassign_booking_'.$order_meta['order_id'].'" name="reassign_booking_'.$order_meta['order_id'].'">
					  <option value=""> --Reassign '.$seat_alias.' --</option>';
		if(!empty($get_available_staff)):
			foreach ( $get_available_staff as $staff ):
					if(isset($staff['name']) && $staff['name'] != "") :
						$reassign_booking .= ' <option value="'.$staff['id'].'">'.ucwords($staff['name']).' </option>';
					endif;
			endforeach;
		endif;
        $reassign_booking .= '</select></div>
              <script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery( "#id_reassign_booking_'.$order_meta['order_id'].'").change(function() {
			var booking_date  = "'.$order_meta['booking_start_date'].'";
			var start_time     = "'.$start_time.'";
			var durations     = "'.$order_meta['booking_time'].'";
			var seat_id     = jQuery( "#id_reassign_booking_'.$order_meta['order_id'].'").val();
			var booking_record_id = '.$order_meta['order_id'].';
			var name = "'.$order_meta['first_name']." ".$order_meta['last_name'].'";
			var start_date  ="'.$order_meta['booking_start_date'].'";
			var end_date  ="'.$order_meta['booking_end_date'].'";
			var base_id  ="'.$order_meta['base_id'].'";
			if(seat_id!="")
			{
				check_staff_availability(seat_id,start_time,durations,booking_date,booking_record_id,name,start_date,end_date,base_id);
			}

		});
	});
</script>';?>
<?php

		if($return_type == 'ajax'){
		 	return $reassign_booking;
		}else{
			echo $reassign_booking;
		}
	}



	public function save_meta_boxes($post_id, $post)
	{
		global $wpdb,$current_user;

		$curr_date = date("Y-m-d H:i:s");	        
		if (isset($_POST) && isset($_POST['is_submit_4']) && $_POST['is_submit_4'] == 1 && is_admin()) 
		{
			$strTableName = 'bkx_booking_record';

			$strAdditionName = '';
			if (isset($_POST['addition_name'])) {
				foreach ($_POST['addition_name'] as $key => $value) {
					$strAdditionName .= $value . ",";
				}
			}
			$booking_start_date = date("Y-m-d H:i:s", strtotime($_POST['input_date'] . " " . $_POST['booking_time_from']));
			$booking_end_date = date("Y-m-d H:i:s", strtotime($_POST['input_date'] . " " . $_POST['booking_time_from']) + $_POST['booking_duration_insec']);
			if (!empty($_POST['flag_stop_redirect'])) {
				$payment_method = 'cash';
			} else {
				$payment_method = 'paypal';
			}

			$booking_set_array = array('seat_id' => sanitize_text_field($_POST['input_seat']), 'base_id' => sanitize_text_field($_POST['input_base']),'extra_id'=>$strAdditionName);
			
			$arrData = array(
				'seat_id' => sanitize_text_field($_POST['input_seat']),
				'base_id' => sanitize_text_field($_POST['input_base']),
				'addition_ids' => $strAdditionName,
				'first_name' => sanitize_text_field($_POST['input_firstname']),
				'last_name' => sanitize_text_field($_POST['input_lastname']),
				'phone' => sanitize_text_field($_POST['input_phonenumber']),
				'email' => sanitize_text_field($_POST['input_email']),
				'street' => sanitize_text_field($_POST['input_street']),
				'city' => sanitize_text_field($_POST['input_city']),
				'state' => sanitize_text_field($_POST['input_state']),
				'postcode' => sanitize_text_field($_POST['input_postcode']),
				'total_price' => sanitize_text_field($_POST['tot_price_val']),
				'total_duration' => str_replace('"', "", sanitize_text_field($_POST['total_duration'])),
				'payment_method' => $payment_method,
				'payment_status' => 'Not Completed',
				'created_date' => $curr_date,
				'created_by' => $current_user->ID,
				'booking_date' => sanitize_text_field($_POST['input_date']),
				'booking_time' => sanitize_text_field($_POST['booking_duration_insec']),
				'extended_base_time' => sanitize_text_field($_POST['input_extended_time']),
				'booking_start_date' => $booking_start_date,
				'booking_end_date' => $booking_end_date,
				'addedtocalendar' => 0,
				'booking_time_from' =>  sanitize_text_field($_POST['booking_time_from']),
				'currency' => bkx_get_current_currency(),
				'order_id' => $post_id,
				'update_order_slot' => sanitize_text_field($_POST['update_order_slot'])
			);

	       $post_update =  $wpdb->update( 
						$wpdb->posts, 
						array( 
							'ping_status' => 'closed',
							//'post_status' => 'bkx-' . apply_filters( 'bkx_default_order_status', 'pending' ),
							'post_password' => uniqid( 'order_' ),
							'post_title' => sprintf( __( 'Order &ndash; %s', 'bookingx' ), strftime( _x( '%b %d, %Y @ %I:%M %p', 'Order date parsed by strftime', 'bookingx' ) ) ),			
						), 
						array( 'ID' => $post_id )
					);
	       	if(!is_wp_error($post_update)){
	       		BkxBooking::generate_order($arrData);

				$booking_data_live = $GLOBALS['bkx_booking_data'];
				$order_id = $booking_data_live['meta_data']['order_id'];
				
	       		if(isset($order_id) && $order_id!='')
	       		{
					$BkxBookingObj = new BkxBooking('',$order_id);
            		$BkxBookingObj->add_order_note( sprintf( __( 'Booking has been successfully updated..', 'bookingx' ), ''), 0, null, $order_id );

	       			//send email that booking confirmed
					$post_status = 'bkx-' . apply_filters( 'bkx_default_order_status', 'pending');
					do_action( 'bkx_order_edit_status', $order_id, $post_status);
					//$res = bkx_do_send_mail($order_id);

	       			$get_blog_id = get_current_blog_id();
	       			$return = get_admin_url($get_blog_id,'edit.php?post_type=bkx_booking');
	       			wp_safe_redirect($return);
	       			die;
	       		}
	       		 
	       	}else{
	       		return;
	       	}
		}
	}
}

new Bkx_Meta_Boxes();