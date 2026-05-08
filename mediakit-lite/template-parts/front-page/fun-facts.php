<?php
/**
 * Fun Facts Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-fun-facts-section mkp-section';

// Get dynamic colors for this section
$colors        = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color    = $colors['text'];

// Check if we have any fun facts and count them
$has_facts  = false;
$fact_count = 0;
for ( $i = 1; $i <= 6; $i++ ) {
	if ( get_theme_mod( 'mkp_fun_fact_' . $i . '_title' ) ) {
		$has_facts = true;
		$fact_count++;
	}
}

// For customizer preview, always render the section structure
$is_customizer = is_customize_preview();

if ( ! $has_facts && ! $is_customizer ) {
	return;
}
?>

<section id="fun_facts" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
	<div class="mkp-container">
		<h2 class="mkp-section__title"><?php echo esc_html( get_theme_mod( 'mkp_fun_facts_section_title', __( 'Fun Facts', 'mediakit-lite' ) ) ); ?></h2>

		<div class="mkp-fun-facts__grid">
			<?php for ( $i = 1; $i <= 6; $i++ ) :
				$title       = get_theme_mod( 'mkp_fun_fact_' . $i . '_title' );
				$image       = get_theme_mod( 'mkp_fun_fact_' . $i . '_image' );
				$description = get_theme_mod( 'mkp_fun_fact_' . $i . '_description' );
				$display     = $title ? 'block' : 'none';
			?>
				<div class="mkp-fun-fact-card mkp-card mkp-fun-fact--<?php echo esc_attr( $i ); ?>" style="display: <?php echo esc_attr( $display ); ?>;" data-fact="<?php echo esc_attr( $i ); ?>">
					<?php if ( $image ) : ?>
						<div class="mkp-fun-fact-card__image-wrap">
							<img class="mkp-fun-fact-card__image" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" />
						</div>
					<?php else : ?>
						<div class="mkp-fun-fact-card__image-wrap mkp-fun-fact-card__image-wrap--placeholder">
							<span class="mkp-fun-fact-card__placeholder">&#9733;</span>
						</div>
					<?php endif; ?>
					<h3 class="mkp-fun-fact-card__title"><?php echo esc_html( $title ); ?></h3>
				</div>
			<?php endfor; ?>
		</div>
	</div>

	<!-- Fun Facts Modal -->
	<div id="mkp-fun-fact-modal" class="mkp-fun-fact-modal" aria-hidden="true" role="dialog" aria-modal="true">
		<div class="mkp-fun-fact-modal__overlay"></div>
		<div class="mkp-fun-fact-modal__content">
			<button class="mkp-fun-fact-modal__close" aria-label="<?php esc_attr_e( 'Close', 'mediakit-lite' ); ?>">&times;</button>
			<div class="mkp-fun-fact-modal__body">
				<div class="mkp-fun-fact-modal__image-col">
					<img class="mkp-fun-fact-modal__image" src="" alt="" />
				</div>
				<div class="mkp-fun-fact-modal__text-col">
					<h3 class="mkp-fun-fact-modal__title"></h3>
					<div class="mkp-fun-fact-modal__description"></div>
				</div>
			</div>
		</div>
	</div>

	<?php // Store fun fact data for JS ?>
	<script type="application/json" id="mkp-fun-facts-data">
		<?php
		$facts_data = array();
		for ( $i = 1; $i <= 6; $i++ ) {
			$title = get_theme_mod( 'mkp_fun_fact_' . $i . '_title' );
			if ( $title ) {
				$facts_data[ $i ] = array(
					'title'       => $title,
					'image'       => get_theme_mod( 'mkp_fun_fact_' . $i . '_image', '' ),
					'description' => wp_kses_post( get_theme_mod( 'mkp_fun_fact_' . $i . '_description', '' ) ),
				);
			}
		}
		echo wp_json_encode( $facts_data );
		?>
	</script>
</section>
