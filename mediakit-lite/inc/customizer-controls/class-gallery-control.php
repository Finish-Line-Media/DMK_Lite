<?php
/**
 * Custom Gallery Control for WordPress Customizer
 *
 * @package MediaKit_Lite
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
    return;
}

/**
 * Gallery Control Class
 */
class MKP_Gallery_Control extends WP_Customize_Control {
    
    /**
     * Control type
     *
     * @var string
     */
    public $type = 'mkp_gallery';
    
    /**
     * Button labels
     *
     * @var array
     */
    public $button_labels = array();
    
    /**
     * Constructor
     */
    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );
        
        // Merge default button labels
        $this->button_labels = wp_parse_args( $this->button_labels, array(
            'select' => __( 'Select Images', 'mediakit-lite' ),
            'change' => __( 'Change Images', 'mediakit-lite' ),
            'remove' => __( 'Remove', 'mediakit-lite' ),
            'placeholder' => __( 'No images selected', 'mediakit-lite' ),
        ) );
    }
    
    /**
     * Enqueue scripts/styles
     */
    public function enqueue() {
        wp_enqueue_media();
        wp_enqueue_script( 
            'mkp-gallery-control', 
            get_template_directory_uri() . '/assets/js/customizer-gallery-control.js', 
            array( 'jquery', 'customize-base' ), 
            MKP_THEME_VERSION, 
            true 
        );
        
        wp_localize_script( 'mkp-gallery-control', 'mkpGallery', array(
            'l10n' => array(
                'title' => __( 'Select Gallery Images', 'mediakit-lite' ),
                'button' => __( 'Select Images', 'mediakit-lite' ),
            ),
        ) );
        
        wp_enqueue_style( 
            'mkp-gallery-control', 
            get_template_directory_uri() . '/assets/css/customizer-gallery-control.css', 
            array(), 
            MKP_THEME_VERSION 
        );
    }
    
    /**
     * Render the control
     */
    public function render_content() {
        $value = $this->value();
        $image_ids = ! empty( $value ) ? explode( ',', $value ) : array();
        ?>
        <div class="mkp-gallery-control">
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif; ?>
            
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
            <?php endif; ?>
            
            <div class="mkp-gallery-control__preview">
                <?php if ( ! empty( $image_ids ) ) : ?>
                    <div class="mkp-gallery-control__images">
                        <?php foreach ( $image_ids as $image_id ) : 
                            $image_url = wp_get_attachment_image_url( $image_id, 'thumbnail' );
                            if ( $image_url ) : ?>
                                <div class="mkp-gallery-control__image" data-id="<?php echo esc_attr( $image_id ); ?>">
                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="">
                                    <button type="button" class="mkp-gallery-control__remove" aria-label="<?php esc_attr_e( 'Remove image', 'mediakit-lite' ); ?>">
                                        <span class="dashicons dashicons-no"></span>
                                    </button>
                                </div>
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="mkp-gallery-control__placeholder">
                        <?php echo esc_html( $this->button_labels['placeholder'] ); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="mkp-gallery-control__buttons">
                <button type="button" class="button mkp-gallery-control__select">
                    <?php echo esc_html( empty( $image_ids ) ? $this->button_labels['select'] : $this->button_labels['change'] ); ?>
                </button>
                <?php if ( ! empty( $image_ids ) ) : ?>
                    <button type="button" class="button mkp-gallery-control__clear">
                        <?php echo esc_html( $this->button_labels['remove'] ); ?>
                    </button>
                <?php endif; ?>
            </div>
            
            <input type="hidden" 
                   class="mkp-gallery-control__value" 
                   value="<?php echo esc_attr( $value ); ?>" 
                   <?php $this->link(); ?> />
        </div>
        <?php
    }
}