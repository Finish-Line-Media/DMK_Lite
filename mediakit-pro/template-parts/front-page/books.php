<?php
/**
 * Books Section Template Part
 *
 * @package MediaKit_Pro
 */

$section_class = 'mkp-books-section';
$section_color = get_theme_mod( 'mkp_books_background_color', '#f1f3f5' );
$books_count = get_theme_mod( 'mkp_books_count', 3 );
?>

<section id="books" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'Books', 'mediakit-pro' ); ?></h2>
        
        <div class="mkp-books__grid">
            <?php for ( $i = 1; $i <= $books_count; $i++ ) : 
                $title = get_theme_mod( 'mkp_book_' . $i . '_title' );
                $cover = get_theme_mod( 'mkp_book_' . $i . '_cover' );
                $description = get_theme_mod( 'mkp_book_' . $i . '_description' );
                $link = get_theme_mod( 'mkp_book_' . $i . '_link' );
                
                if ( $title ) : ?>
                    <div class="mkp-book-card">
                        <?php if ( $cover ) : ?>
                            <div class="mkp-book-card__cover">
                                <img src="<?php echo esc_url( $cover ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
                            </div>
                        <?php endif; ?>
                        
                        <div class="mkp-book-card__content">
                            <h3 class="mkp-book-card__title"><?php echo esc_html( $title ); ?></h3>
                            
                            <?php if ( $description ) : ?>
                                <div class="mkp-book-card__description">
                                    <?php echo wp_kses_post( wpautop( $description ) ); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $link ) : ?>
                                <a href="<?php echo esc_url( $link ); ?>" class="mkp-btn mkp-btn--primary mkp-btn--small" target="_blank" rel="noopener">
                                    <?php esc_html_e( 'Learn More', 'mediakit-pro' ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>