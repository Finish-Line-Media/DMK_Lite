<?php
/**
 * Books Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-books-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

// Count actual books with titles
$actual_book_count = 0;
for ( $i = 1; $i <= 6; $i++ ) {
    $title = get_theme_mod( 'mkp_book_' . $i . '_title' );
    if ( $title ) {
        $actual_book_count++;
    }
}

// For customizer preview
$is_customizer = is_customize_preview();

// Get customizable section title (defaults to singular/plural based on count)
$default_title = ( $actual_book_count === 1 ) ? __( 'Book', 'mediakit-lite' ) : __( 'Books', 'mediakit-lite' );
$section_title = get_theme_mod( 'mkp_books_section_title', $default_title );

// Get books per row setting
$books_per_row = get_theme_mod( 'mkp_books_per_row', '3' );

// Get text alignment setting
$text_align = get_theme_mod( 'mkp_books_text_align', 'left' );
$description_class = 'mkp-masonry-card__description mkp-text-align-' . $text_align;

// Always add a column class
if ( $books_per_row === '1' || $actual_book_count === 1 ) {
    $grid_class = ' mkp-books__grid--one-column';
} elseif ( $books_per_row === '2' ) {
    $grid_class = ' mkp-books__grid--two-columns';
} else {
    $grid_class = ' mkp-books__grid--three-columns';
}
?>

<section id="books" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( $section_title ); ?></h2>
        
        <div class="mkp-books__grid<?php echo esc_attr( $grid_class ); ?>">
            <?php for ( $i = 1; $i <= 6; $i++ ) : 
                $title = get_theme_mod( 'mkp_book_' . $i . '_title' );
                $cover = get_theme_mod( 'mkp_book_' . $i . '_cover' );
                $description = get_theme_mod( 'mkp_book_' . $i . '_description' );
                $link = get_theme_mod( 'mkp_book_' . $i . '_link' );
                $book_class = $title ? '' : ' mkp-book--hidden';
                ?>
                <div class="mkp-book-card mkp-card mkp-book--<?php echo esc_attr( $i ); ?><?php echo esc_attr( $book_class ); ?>">
                    <div class="mkp-book-card__cover">
                        <?php if ( $cover ) : ?>
                            <img src="<?php echo esc_url( $cover ); ?>" alt="<?php echo esc_attr( $title ); ?> cover" loading="lazy" />
                        <?php else : ?>
                            <div class="mkp-book-card__cover-placeholder">
                                <span><?php esc_html_e( 'Book Cover', 'mediakit-lite' ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mkp-book-card__content">
                        <h3 class="mkp-book-card__title"><?php echo esc_html( $title ); ?></h3>
                        
                        <div class="<?php echo esc_attr( $description_class ); ?>">
                            <?php if ( $description ) : ?>
                                <?php echo wp_kses_post( wpautop( $description ) ); ?>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ( $link ) : ?>
                            <a href="<?php echo esc_url( $link ); ?>" class="mkp-btn mkp-btn--primary mkp-btn--small" target="_blank" rel="noopener">
                                <?php esc_html_e( 'Learn More', 'mediakit-lite' ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>