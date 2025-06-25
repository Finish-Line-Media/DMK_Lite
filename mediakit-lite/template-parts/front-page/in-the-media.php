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

$section_bg = get_theme_mod( 'mkp_in_the_media_background_color', '#ffffff' );
$media_items = array();

// Collect all media items
for ( $i = 1; $i <= 8; $i++ ) {
	$title = get_theme_mod( 'mkp_media_item_' . $i . '_title' );
	if ( ! empty( $title ) ) {
		$media_items[] = array(
			'title'       => $title,
			'type'        => get_theme_mod( 'mkp_media_item_' . $i . '_type', 'video' ),
			'url'         => get_theme_mod( 'mkp_media_item_' . $i . '_url' ),
			'date'        => get_theme_mod( 'mkp_media_item_' . $i . '_date' ),
			'description' => get_theme_mod( 'mkp_media_item_' . $i . '_description' ),
			'thumbnail'   => get_theme_mod( 'mkp_media_item_' . $i . '_thumbnail' ),
		);
	}
}

if ( empty( $media_items ) ) {
	return;
}
?>

<section id="in-the-media" class="mkp-section mkp-in-the-media" style="background-color: <?php echo esc_attr( $section_bg ); ?>">
	<div class="mkp-container">
		<h2 class="mkp-section__title"><?php echo esc_html( get_theme_mod( 'mkp_in_the_media_section_title', __( 'In The Media', 'mediakit-lite' ) ) ); ?></h2>
		
		<?php if ( get_theme_mod( 'mkp_in_the_media_subtitle' ) ) : ?>
			<p class="mkp-section__subtitle"><?php echo esc_html( get_theme_mod( 'mkp_in_the_media_subtitle' ) ); ?></p>
		<?php endif; ?>

		<div class="mkp-media-grid">
			<?php foreach ( $media_items as $item ) : ?>
				<div class="mkp-media-item mkp-media-item--<?php echo esc_attr( $item['type'] ); ?>">
					<?php
					// Handle embeds for video and audio content
					if ( in_array( $item['type'], array( 'video', 'audio' ), true ) && ! empty( $item['url'] ) ) {
						$embed = wp_oembed_get( $item['url'] );
						if ( $embed ) {
							echo '<div class="mkp-media-item__embed">';
							echo $embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							echo '</div>';
						} elseif ( ! empty( $item['thumbnail'] ) ) {
							// Fallback to thumbnail if embed fails
							?>
							<div class="mkp-media-item__thumbnail">
								<a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener">
									<img src="<?php echo esc_url( $item['thumbnail'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
									<span class="mkp-media-item__play-icon" aria-hidden="true"></span>
								</a>
							</div>
							<?php
						}
					} elseif ( ! empty( $item['thumbnail'] ) ) {
						// For articles or if no embed available
						?>
						<div class="mkp-media-item__thumbnail">
							<a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener">
								<img src="<?php echo esc_url( $item['thumbnail'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
							</a>
						</div>
						<?php
					}
					?>

					<div class="mkp-media-item__content">
						<h3 class="mkp-media-item__title">
							<?php if ( ! empty( $item['url'] ) ) : ?>
								<a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener">
									<?php echo esc_html( $item['title'] ); ?>
								</a>
							<?php else : ?>
								<?php echo esc_html( $item['title'] ); ?>
							<?php endif; ?>
						</h3>

						<?php if ( ! empty( $item['date'] ) ) : ?>
							<time class="mkp-media-item__date" datetime="<?php echo esc_attr( $item['date'] ); ?>">
								<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $item['date'] ) ) ); ?>
							</time>
						<?php endif; ?>

						<?php if ( ! empty( $item['description'] ) ) : ?>
							<p class="mkp-media-item__description"><?php echo esc_html( $item['description'] ); ?></p>
						<?php endif; ?>

						<span class="mkp-media-item__type-badge mkp-media-item__type-badge--<?php echo esc_attr( $item['type'] ); ?>">
							<?php
							switch ( $item['type'] ) {
								case 'video':
									echo esc_html__( 'Video', 'mediakit-lite' );
									break;
								case 'audio':
									echo esc_html__( 'Podcast', 'mediakit-lite' );
									break;
								case 'article':
									echo esc_html__( 'Article', 'mediakit-lite' );
									break;
								default:
									echo esc_html__( 'Media', 'mediakit-lite' );
							}
							?>
						</span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>