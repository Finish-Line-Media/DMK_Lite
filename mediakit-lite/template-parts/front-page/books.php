<?php
/**
 * Books Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-books-section';
$section_color = get_theme_mod( 'mkp_books_background_color', '#f8f9fa' );

// Count actual books with titles
$actual_book_count = 0;
for ( $i = 1; $i <= 4; $i++ ) {
    $title = get_theme_mod( 'mkp_book_' . $i . '_title' );
    if ( $title ) {
        $actual_book_count++;
    }
}

// Don't show section if no books
if ( $actual_book_count === 0 ) {
    return;
}

// Determine section title based on count
$section_title = ( $actual_book_count === 1 ) ? __( 'Book', 'mediakit-lite' ) : __( 'Books', 'mediakit-lite' );
?>

<section id="books" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( $section_title ); ?></h2>
        
        <div class="mkp-books__grid<?php echo $actual_book_count === 1 ? ' mkp-books__grid--single' : ''; ?>">
            <?php for ( $i = 1; $i <= 4; $i++ ) : 
                $title = get_theme_mod( 'mkp_book_' . $i . '_title' );
                $cover = get_theme_mod( 'mkp_book_' . $i . '_cover' );
                $description = get_theme_mod( 'mkp_book_' . $i . '_description' );
                $link = get_theme_mod( 'mkp_book_' . $i . '_link' );
                $display = $title ? 'block' : 'none';
                ?>
                <div class="mkp-book-card mkp-book--<?php echo esc_attr( $i ); ?>" style="display: <?php echo esc_attr( $display ); ?>;">
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
                        
                        <div class="mkp-book-card__description">
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