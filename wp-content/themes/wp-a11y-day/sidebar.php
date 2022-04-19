<?php
/**
 * Sidebar template
 */
?>
<aside id="sidebar-widgets" aria-label="Sidebar">
<?php
if ( is_page() ) {
	dynamic_sidebar( 'page-sidebar-widget-area' );
}
if ( is_single() ) {
	dynamic_sidebar( 'sidebar-widget-area' );
}
?>
</aside>