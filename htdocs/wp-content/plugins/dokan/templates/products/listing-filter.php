<?php
/**
 * Dokan Dahsboard Product Listing
 * filter template
 *
 * @since 2.4
 *
 * @package dokan
 */
?>
<?php do_action( 'dokan_product_listing_filter_before_form' ); ?>

    <form class="dokan-form-inline dokan-w6" method="get" >

        <div class="dokan-form-group">
            <?php dokan_product_listing_filter_months_dropdown( get_current_user_id() ); ?>
        </div>

        <div class="dokan-form-group">
            <?php
                wp_dropdown_categories( array(
                    'show_option_none' => __( '- Select a category -', 'dokan' ),
                    'hierarchical'     => 1,
                    'hide_empty'       => 0,
                    'name'             => 'product_cat',
                    'id'               => 'product_cat',
                    'taxonomy'         => 'product_cat',
                    'title_li'         => '',
                    'class'            => 'product_cat dokan-form-control chosen',
                    'exclude'          => '',
                    'selected'         => isset( $_GET['product_cat'] ) ? $_GET['product_cat'] : '-1',
                ) );
            ?>
        </div>

        <?php
        if ( isset( $_GET['product_search_name'] ) ) { ?>
            <input type="hidden" name="product_search_name" value="<?php echo $_GET['product_search_name']; ?>">
        <?php }
        ?>

        <button type="submit" name="product_listing_filter" value="ok" class="dokan-btn dokan-btn-theme"><?php _e( 'Filter', 'dokan'); ?></button>

    </form>

    <?php do_action( 'dokan_product_listing_filter_before_search_form' ); ?>

    <form method="get" class="dokan-form-inline dokan-w6">

        <button type="submit" name="product_listing_search" value="ok" class="dokan-btn dokan-btn-theme dokan-right"><?php _e( 'Search', 'dokan'); ?></button>

        <?php wp_nonce_field( 'dokan_product_search', 'dokan_product_search_nonce' ); ?>

        <div class="dokan-form-group dokan-right">
            <input type="text" class="dokan-form-control" name="product_search_name" placeholder="Search Products" value="<?php echo isset( $_GET['product_search_name'] ) ? $_GET['product_search_name'] : '' ?>">
        </div>

        <?php
        if ( isset( $_GET['product_cat'] ) ) { ?>
            <input type="hidden" name="product_cat" value="<?php echo $_GET['product_cat']; ?>">
        <?php }

        if ( isset( $_GET['date'] ) ) { ?>
            <input type="hidden" name="date" value="<?php echo $_GET['date']; ?>">
        <?php }
        ?>
    </form>

    <?php do_action( 'dokan_product_listing_filter_after_form' ); ?>
