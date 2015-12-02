<?php

/**
*  Product Functionality for Product Handler
*
*  @since 2.4
*
*  @package dokan
*/
class Dokan_Template_Products {

    public static $errors;
    public static $product_cat;
    public static $post_content;

    /**
     *  Load autometially when class initiate
     *
     *  @since 2.4
     *
     *  @uses actions
     *  @uses filters
     */
    function __construct() {
        add_action( 'dokan_render_product_listing_template', array( $this, 'render_product_listing_template' ), 11 );
        add_action( 'template_redirect', array( $this, 'handle_all_submit' ), 11 );
        add_action( 'template_redirect', array( $this, 'handle_delete_product' ) );
        add_action( 'dokan_render_new_product_template', array( $this, 'render_new_product_template' ), 10 );
        add_action( 'dokan_render_product_edit_template', array( $this, 'load_product_edit_template' ), 11 );
    }

    /**
     * Singleton method
     *
     * @return self
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Dokan_Template_Products();
        }

        return $instance;
    }

    /**
     * Render New Product Template for only free version
     *
     * @since 2.4
     *
     * @param  array $query_vars
     *
     * @return void
     */
    public function render_new_product_template( $query_vars ) {

        if ( isset( $query_vars['new-product'] ) && !WeDevs_Dokan::init()->is_pro() ) {
            dokan_get_template_part( 'products/new-product-single' );
        }
    }

    /**
     * Load Product Edit Template
     *
     * @since 2.4
     *
     * @return void
     */
    public function load_product_edit_template() {
        if ( !WeDevs_Dokan::init()->is_pro() ) {
            dokan_get_template_part( 'products/new-product-single' );
        }
    }

    /**
     * Render Product Listing Template
     *
     * @since 2.4
     *
     * @param  string $action
     *
     * @return void
     */
    public function render_product_listing_template( $action ) {
        dokan_get_template_part( 'products/products-listing');
    }

    /**
     * Handle all the form POST submit
     *
     * @return void
     */
    function handle_all_submit() {

        if ( ! is_user_logged_in() ) {
            return;
        }

        if ( ! dokan_is_user_seller( get_current_user_id() ) ) {
            return;
        }

        $errors = array();
        self::$product_cat  = -1;
        self::$post_content = __( 'Details of your product ...', 'dokan' );

        if ( ! $_POST ) {
            return;
        }

        if ( isset( $_POST['dokan_add_product'] ) && wp_verify_nonce( $_POST['dokan_add_new_product_nonce'], 'dokan_add_new_product' ) ) {

            $post_title     = trim( $_POST['post_title'] );
            $post_content   = trim( $_POST['post_content'] );
            $post_excerpt   = isset( $_POST['post_excerpt'] ) ? trim( $_POST['post_excerpt'] ) : '';
            $price          = floatval( $_POST['_regular_price'] );
            $featured_image = absint( $_POST['feat_image_id'] );

            if ( empty( $post_title ) ) {

                $errors[] = __( 'Please enter product title', 'dokan' );
            }

            if( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'single' ) {
                $product_cat    = intval( $_POST['product_cat'] );
                if ( $product_cat < 0 ) {
                    $errors[] = __( 'Please select a category', 'dokan' );
                }
            } else {
                if( !isset( $_POST['product_cat'] ) && empty( $_POST['product_cat'] ) ) {
                    $errors[] = __( 'Please select AT LEAST ONE category', 'dokan' );
                }
            }

            if ( isset( $_POST['dokan_product_id'] ) && empty( $_POST['dokan_product_id'] ) ) {
                self::$errors = apply_filters( 'dokan_can_add_product', $errors );
            } else {
                self::$errors = apply_filters( 'dokan_can_edit_product', $errors );
            }

            if ( !self::$errors ) {

                if( isset( $_POST['dokan_product_id'] ) && empty( $_POST['dokan_product_id'] ) ) {
                    $product_status = dokan_get_new_post_status();
                    $post_data = apply_filters( 'dokan_insert_product_post_data', array(
                        'post_type'    => 'product',
                        'post_status'  => $product_status,
                        'post_title'   => $post_title,
                        'post_content' => $post_content,
                        'post_excerpt' => $post_excerpt,
                    ) );

                    $product_id = wp_insert_post( $post_data );

                } else {
                    $post_id = (int)$_POST['dokan_product_id'];
                    $product_info = apply_filters( 'dokan_update_product_post_data', array(
                        'ID'             => $post_id,
                        'post_title'     => sanitize_text_field( $_POST['post_title'] ),
                        'post_content'   => $_POST['post_content'],
                        'post_excerpt'   => $_POST['post_excerpt'],
                        'post_status'    => isset( $_POST['post_status'] ) ? $_POST['post_status'] : 'pending',
                        'comment_status' => isset( $_POST['_enable_reviews'] ) ? 'open' : 'closed'
                    ) );

                    $product_id = wp_update_post( $product_info );
                }

                if ( $product_id ) {

                    /** set images **/
                    if ( $featured_image ) {
                        set_post_thumbnail( $product_id, $featured_image );
                    }

                    if( isset( $_POST['product_tag'] ) && !empty( $_POST['product_tag'] ) ) {
                        $tags_ids = array_map( 'intval', (array)$_POST['product_tag'] );
                        wp_set_object_terms( $product_id, $tags_ids, 'product_tag' );
                    }

                    /** set product category * */
                    if( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'single' ) {
                        wp_set_object_terms( $product_id, (int) $_POST['product_cat'], 'product_cat' );
                    } else {
                        if( isset( $_POST['product_cat'] ) && !empty( $_POST['product_cat'] ) ) {
                            $cat_ids = array_map( 'intval', (array)$_POST['product_cat'] );
                            wp_set_object_terms( $product_id, $cat_ids, 'product_cat' );
                        }
                    }

                    /** Set Product type by default simple */
                    if( isset( $_POST['_create_variation'] ) && $_POST['_create_variation'] == 'yes' ) {
                        wp_set_object_terms( $product_id, 'variable', 'product_type' );
                    } else {
                        wp_set_object_terms( $product_id, 'simple', 'product_type' );
                    }


                    update_post_meta( $product_id, '_regular_price', $price );
                    update_post_meta( $product_id, '_sale_price', '' );
                    update_post_meta( $product_id, '_price', $price );
                    update_post_meta( $product_id, '_visibility', 'visible' );

                    dokan_new_process_product_meta( $product_id );

                    if( isset( $_POST['dokan_product_id'] ) && empty( $_POST['dokan_product_id'] ) ) {
                        do_action( 'dokan_new_product_added', $product_id, $post_data );
                    }

                    if( isset( $_POST['dokan_product_id'] ) && empty( $_POST['dokan_product_id'] ) ) {
                        if ( dokan_get_option( 'product_add_mail', 'dokan_general', 'on' ) == 'on' ) {
                            Dokan_Email::init()->new_product_added( $product_id, $product_status );
                        }
                    }

                    wp_redirect( add_query_arg( array( 'message' => 'success' ), dokan_edit_product_url( $product_id ) ) );
                    exit;
                }
            }
        }

        if ( isset( $_POST['add_product'] ) && wp_verify_nonce( $_POST['dokan_add_new_product_nonce'], 'dokan_add_new_product' ) ) {
            $post_title     = trim( $_POST['post_title'] );
            $post_content   = trim( $_POST['post_content'] );
            $post_excerpt   = trim( $_POST['post_excerpt'] );
            $price          = floatval( $_POST['price'] );
            $featured_image = absint( $_POST['feat_image_id'] );

            if ( empty( $post_title ) ) {

                $errors[] = __( 'Please enter product title', 'dokan' );
            }

            if( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'single' ) {
                $product_cat    = intval( $_POST['product_cat'] );
                if ( $product_cat < 0 ) {
                    $errors[] = __( 'Please select a category', 'dokan' );
                }
            } else {
                if( !isset( $_POST['product_cat'] ) && empty( $_POST['product_cat'] ) ) {
                    $errors[] = __( 'Please select AT LEAST ONE category', 'dokan' );
                }
            }

            self::$errors = apply_filters( 'dokan_can_add_product', $errors );

            if ( !self::$errors ) {

                $product_status = dokan_get_new_post_status();
                $post_data = apply_filters( 'dokan_insert_product_post_data', array(
                        'post_type'    => 'product',
                        'post_status'  => $product_status,
                        'post_title'   => $post_title,
                        'post_content' => $post_content,
                        'post_excerpt' => $post_excerpt,
                    ) );

                $product_id = wp_insert_post( $post_data );

                if ( $product_id ) {

                    /** set images **/
                    if ( $featured_image ) {
                        set_post_thumbnail( $product_id, $featured_image );
                    }

                    if( isset( $_POST['product_tag'] ) && !empty( $_POST['product_tag'] ) ) {
                        $tags_ids = array_map( 'intval', (array)$_POST['product_tag'] );
                        wp_set_object_terms( $product_id, $tags_ids, 'product_tag' );
                    }

                    /** set product category * */
                    if( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'single' ) {
                        wp_set_object_terms( $product_id, (int) $_POST['product_cat'], 'product_cat' );
                    } else {
                        if( isset( $_POST['product_cat'] ) && !empty( $_POST['product_cat'] ) ) {
                            $cat_ids = array_map( 'intval', (array)$_POST['product_cat'] );
                            wp_set_object_terms( $product_id, $cat_ids, 'product_cat' );
                        }
                    }

                    /** Set Product type by default simple */
                    wp_set_object_terms( $product_id, 'simple', 'product_type' );

                    update_post_meta( $product_id, '_regular_price', $price );
                    update_post_meta( $product_id, '_sale_price', '' );
                    update_post_meta( $product_id, '_price', $price );
                    update_post_meta( $product_id, '_visibility', 'visible' );

                    do_action( 'dokan_new_product_added', $product_id, $post_data );

                    if ( dokan_get_option( 'product_add_mail', 'dokan_general', 'on' ) == 'on' ) {
                        Dokan_Email::init()->new_product_added( $product_id, $product_status );
                    }

                    wp_redirect( dokan_edit_product_url( $product_id ) );
                    exit;
                }
            }
        }


        if ( isset( $_GET['product_id'] ) ) {
            $post_id = intval( $_GET['product_id'] );
        } else {
            global $post, $product;

            if ( !empty( $post ) ) {
                $post_id = $post->ID;
            }
        }


        if ( isset( $_POST['update_product'] ) && wp_verify_nonce( $_POST['dokan_edit_product_nonce'], 'dokan_edit_product' ) ) {
            $post_title     = trim( $_POST['post_title'] );
            if ( empty( $post_title ) ) {

                $errors[] = __( 'Please enter product title', 'dokan' );
            }

            if( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'single' ) {
                $product_cat    = intval( $_POST['product_cat'] );
                if ( $product_cat < 0 ) {
                    $errors[] = __( 'Please select a category', 'dokan' );
                }
            } else {
                if( !isset( $_POST['product_cat'] ) && empty( $_POST['product_cat'] ) ) {
                    $errors[] = __( 'Please select AT LEAST ONE category', 'dokan' );
                }
            }

            self::$errors = apply_filters( 'dokan_can_edit_product', $errors );

            if ( !self::$errors ) {

                $product_info = array(
                    'ID'             => $post_id,
                    'post_title'     => sanitize_text_field( $_POST['post_title'] ),
                    'post_content'   => $_POST['post_content'],
                    'post_excerpt'   => $_POST['post_excerpt'],
                    'post_status'    => isset( $_POST['post_status'] ) ? $_POST['post_status'] : 'pending',
                    'comment_status' => isset( $_POST['_enable_reviews'] ) ? 'open' : 'closed'
                );

                wp_update_post( $product_info );

                /** Set Product tags */
                if( isset( $_POST['product_tag'] ) ) {
                    $tags_ids = array_map( 'intval', (array)$_POST['product_tag'] );
                } else {
                    $tags_ids = array();
                }
                wp_set_object_terms( $post_id, $tags_ids, 'product_tag' );


                /** set product category * */

                if( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'single' ) {
                    wp_set_object_terms( $post_id, (int) $_POST['product_cat'], 'product_cat' );
                } else {
                    if( isset( $_POST['product_cat'] ) && !empty( $_POST['product_cat'] ) ) {
                        $cat_ids = array_map( 'intval', (array)$_POST['product_cat'] );
                        wp_set_object_terms( $post_id, $cat_ids, 'product_cat' );
                    }
                }

                wp_set_object_terms( $post_id, 'simple', 'product_type' );

                /**  Process all variation products meta */
                dokan_process_product_meta( $post_id );

                /** set images **/
                $featured_image = absint( $_POST['feat_image_id'] );
                if ( $featured_image ) {
                    set_post_thumbnail( $post_id, $featured_image );
                }

                $edit_url = dokan_edit_product_url( $post_id );
                wp_redirect( add_query_arg( array( 'message' => 'success' ), $edit_url ) );
                exit;
            }
        }


    }

    /**
     * Handle delete product link
     *
     * @return void
     */
    function handle_delete_product() {

        if ( ! is_user_logged_in() ) {
            return;
        }

        if ( ! dokan_is_user_seller( get_current_user_id() ) ) {
            return;
        }

        dokan_delete_product_handler();
    }

}