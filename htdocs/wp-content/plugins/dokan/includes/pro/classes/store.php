<?php
/**
 * Dokan Notice Class
 *
 * @since  2.4.3
 *
 * @author weDevs  <info@wedevs.com>
 */
class Dokan_Pro_Store {

    /**
     * Load autometically when class initiate
     *
     * @since 2.4.3
     *
     * @uses action hook
     * @uses filter hook
     */
    function __construct() {
        add_action( 'dokan_rewrite_rules_loaded', array( $this, 'load_rewrite_rules' ) );
        add_filter( 'dokan_query_var_filter', array( $this, 'load_store_review_query_var' ), 10, 2 );
        add_filter( 'dokan_store_tabs', array( $this, 'add_review_tab_in_store' ), 10, 2 );
        add_filter( 'template_include', array( $this, 'store_review_template' ), 99 );
    }

    /**
     * Initializes the Dokan_Pro_Store() class
     *
     * Checks for an existing Dokan_Pro_Store() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( !$instance ) {
            $instance = new Dokan_Pro_Store();
        }

        return $instance;
    }

    /**
     * Load Store Review query vars for store page
     *
     * @since 2.4.3
     *
     * @param  array $vars
     *
     * @return array
     */
    public function load_store_review_query_var( $vars ) {
        $vars[] = 'store_review';

        return $vars;
    }

    /**
     * Load Rewrite Rules for store page
     *
     * @since 2.4.3
     *
     * @param  string $custom_store_url
     *
     * @return void
     */
    public function load_rewrite_rules( $custom_store_url ) {
        add_rewrite_rule( $custom_store_url.'/([^/]+)/reviews?$', 'index.php?'.$custom_store_url.'=$matches[1]&store_review=true', 'top' );
        add_rewrite_rule( $custom_store_url.'/([^/]+)/reviews/page/?([0-9]{1,})/?$', 'index.php?'.$custom_store_url.'=$matches[1]&paged=$matches[2]&store_review=true', 'top' );
    }

    /**
     * Add Review Tab in Store Page
     *
     * @since 2.4.3
     *
     * @param array $tabs
     * @param integer $store_id
     *
     * @return array
     */
    public function add_review_tab_in_store( $tabs, $store_id ) {
        $tabs['reviews'] = array(
            'title' => __( 'Reviews', 'dokan' ),
            'url'   => dokan_get_review_url( $store_id )
        );

        return $tabs;
    }

    /**
     * Returns the store review template
     *
     * @since 2.4.3
     *
     * @param string  $template
     *
     * @return string
     */
    public function store_review_template( $template ) {

        if ( ! function_exists( 'WC' ) ) {
            return $template;
        }

        if ( get_query_var( 'store_review' ) ) {
            return dokan_locate_template( 'store-reviews.php', '', '', true );
        }

        return $template;
    }

}