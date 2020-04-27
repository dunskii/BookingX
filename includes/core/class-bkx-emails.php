<?php
defined( 'ABSPATH' ) || exit;
class BKX_Emails
{
    public $emails = array();

    protected static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->init();

        // Email Header, Footer and content hooks.
        add_action( 'bookingx_email_header', array( $this, 'email_header' ) );
        add_action( 'bookingx_email_footer', array( $this, 'email_footer' ) );
        add_action( 'bookingx_email_booking_details', array( $this, 'booking_details' ), 10, 4 );
        add_action( 'bookingx_email_customer_details', array( $this, 'email_addresses' ), 20, 3 );

        // Hook for replacing {site_title} in email-footer.
        add_filter( 'bookingx_email_footer_text', array( $this, 'replace_placeholders' ) );

        // Let 3rd parties unhook the above via this hook.
        do_action( 'bookingx_email', $this );
    }

    public function get_emails() {
        return $this->emails;
    }

    public function init() {
        // Include email classes.
        $this->emails['BKX_Email_Pending_Booking']                 = include BKX_PLUGIN_DIR_PATH.'/includes/core/emails/class-bkx-email-new-booking.php';
        $this->emails['BKX_Email_Cancelled_Booking']           = include BKX_PLUGIN_DIR_PATH.'/includes/core/emails/class-bkx-email-cancelled-booking.php';
        $this->emails['BKX_Email_Customer_Pending_Booking']    = include BKX_PLUGIN_DIR_PATH.'/includes/core/emails/class-bkx-email-customer-pending-booking.php';
        $this->emails['BKX_Email_Customer_Ack_Booking']         = include BKX_PLUGIN_DIR_PATH.'/includes/core/emails/class-bkx-email-customer-ack-booking.php';
        $this->emails['BKX_Email_Customer_Cancelled_Booking']    = include BKX_PLUGIN_DIR_PATH.'/includes/core/emails/class-bkx-email-customer-cancelled-booking.php';
        $this->emails['BKX_Email_Customer_Completed_Booking']  = include BKX_PLUGIN_DIR_PATH.'/includes/core/emails/class-bkx-email-customer-completed-booking.php';
        $this->emails = apply_filters( 'bookingx_email_classes', $this->emails );
    }

    public function email_header( $email_heading ) {
        bkx_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading ) );
    }

    public function email_footer() {
        bkx_get_template( 'emails/email-footer.php' );
    }

    public function send( $to, $subject, $message, $headers = "Content-Type: text/html\r\n", $attachments = '' ) {
        // Send.
        $email = new BookingX_Email_Content();
        return $email->send( $to, $subject, $message, $headers, $attachments );
    }
}