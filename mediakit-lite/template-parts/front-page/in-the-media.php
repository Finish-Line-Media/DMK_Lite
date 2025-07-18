<?php
/**
 * Template part for displaying the In The Media section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MediaKit_Lite
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_bg = $colors['background'];
$text_color = $colors['text'];
?>

<section id="in_the_media" class="mkp-section mkp-in-the-media" style="background-color: <?php echo esc_attr( $section_bg ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
	<div class="mkp-container">
		<h2 class="mkp-section__title"><?php echo esc_html( get_theme_mod( 'mkp_in_the_media_section_title', __( 'In The Media', 'mediakit-lite' ) ) ); ?></h2>
		
		<div class="mkp-media-grid">
			<?php for ( $i = 1; $i <= 8; $i++ ) : 
				$url = get_theme_mod( 'mkp_media_item_' . $i . '_url' );
				
				if ( ! empty( $url ) ) :
					$embed = wp_oembed_get( $url );
					
					if ( $embed ) : 
						// Determine embed type based on URL
						$embed_class = 'mkp-embed--video'; // Default
						if ( strpos( $url, 'youtube.com' ) !== false || strpos( $url, 'youtu.be' ) !== false ) {
							$embed_class = 'mkp-embed--youtube';
						} elseif ( strpos( $url, 'vimeo.com' ) !== false ) {
							$embed_class = 'mkp-embed--vimeo';
						} elseif ( strpos( $url, 'spotify.com' ) !== false ) {
							$embed_class = 'mkp-embed--spotify';
						} elseif ( strpos( $url, 'twitter.com' ) !== false || strpos( $url, 'x.com' ) !== false ) {
							$embed_class = 'mkp-embed--twitter';
						} elseif ( strpos( $url, 'instagram.com' ) !== false ) {
							$embed_class = 'mkp-embed--instagram';
						} elseif ( strpos( $url, 'facebook.com' ) !== false ) {
							$embed_class = 'mkp-embed--facebook';
						} elseif ( strpos( $url, 'tiktok.com' ) !== false ) {
							$embed_class = 'mkp-embed--tiktok';
						}
						?>
						<div class="mkp-media-embed">
							<div class="mkp-embed-responsive <?php echo esc_attr( $embed_class ); ?>">
								<?php echo $embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</div>
					<?php endif;
				endif;
			endfor; ?>
		</div>
	</div>
</section>