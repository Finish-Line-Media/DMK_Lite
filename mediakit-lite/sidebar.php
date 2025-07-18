<?php
/**
 * The sidebar containing the main widget area
 *
 * @package MediaKit_Lite
 */

// Check if sidebar should be shown based on customizer settings
if ( ! mkp_should_show_sidebar() ) {
    return;
}
?>

<aside id="secondary" class="mkp-sidebar mkp-card widget-area">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->