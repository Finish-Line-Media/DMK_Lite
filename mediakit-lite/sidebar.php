<?php
/**
 * The sidebar containing the main widget area
 *
 * @package MediaKit_Lite
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<aside id="secondary" class="mkp-sidebar widget-area">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>