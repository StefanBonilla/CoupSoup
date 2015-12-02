<?php
/**
 *  Dashboard Widget Template
 *
 *  Dashboard Big Counter widget template
 *
 *  @since 2.4
 *
 *  @author weDevs <info@wedevs.com>
 *
 *  @package dokan
 */
?>
<div class="dashboard-widget big-counter">
    <ul class="list-inline">
        <li>
            <div class="title"><?php _e( 'Pageview', 'dokan' ); ?></div>
            <div class="count"><?php echo dokan_number_format( $pageviews ); ?></div>
        </li>
        <li>
            <div class="title"><?php _e( 'Order', 'dokan' ); ?></div>
            <div class="count">
                <?php
                $total = $orders_count->{'wc-completed'} + $orders_count->{'wc-processing'} + $orders_count->{'wc-on-hold'};
                echo number_format_i18n( $total, 0 );
                ?>
            </div>
        </li>
        <li>
            <div class="title"><?php _e( 'Sales', 'dokan' ); ?></div>
            <div class="count"><?php echo woocommerce_price( $earning ); ?></div>
        </li>
        <li>
            <div class="title"><?php _e( 'Earning', 'dokan' ); ?></div>
            <div class="count"><?php echo $seller_balance; ?></div>
        </li>

        <?php do_action( 'dokan_seller_dashboard_widget_counter' ); ?>

    </ul>
</div> <!-- .big-counter -->
