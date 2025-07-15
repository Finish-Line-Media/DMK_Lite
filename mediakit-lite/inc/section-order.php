<?php
/**
 * Section ordering functionality
 *
 * @package MediaKit_Lite
 */

/**
 * Get default section order
 *
 * @return array
 */
function mkp_get_default_section_order() {
    $sections = mkp_get_all_sections_config();
    return array_keys( $sections );
}

/**
 * Get section order
 *
 * @return array
 */
function mkp_get_section_order() {
    $default_order = mkp_get_default_section_order();
    $saved_order = get_theme_mod( 'mkp_section_order', '' );
    
    if ( ! empty( $saved_order ) ) {
        $order = explode( ',', $saved_order );
        // Validate saved order
        if ( count( $order ) === count( $default_order ) ) {
            return $order;
        }
    }
    
    return $default_order;
}

/**
 * Add section order customizer control
 *
 * @param WP_Customize_Manager $wp_customize Customizer object
 */
function mkp_add_section_order_customizer( $wp_customize ) {
    // Add section for ordering
    $wp_customize->add_section( 'mkp_section_order', array(
        'title'       => __( 'Section Order', 'mediakit-lite' ),
        'description' => __( 'Drag and drop to reorder the front page sections.', 'mediakit-lite' ),
        'priority'    => 15,
        'capability'  => 'edit_theme_options',
    ) );
    
    // Add setting
    $wp_customize->add_setting( 'mkp_section_order', array(
        'default'           => implode( ',', mkp_get_default_section_order() ),
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'mkp_sanitize_section_order',
        'transport'         => 'refresh',
    ) );
    
    // Add custom control
    $wp_customize->add_control( new Mkp_Section_Order_Control( 
        $wp_customize, 
        'mkp_section_order', 
        array(
            'label'    => __( 'Front Page Section Order', 'mediakit-lite' ),
            'section'  => 'mkp_section_order',
            'settings' => 'mkp_section_order',
            'priority' => 10,
        ) 
    ) );
}
add_action( 'customize_register', 'mkp_add_section_order_customizer', 20 );

/**
 * Sanitize section order
 *
 * @param string $input Input value
 * @return string
 */
function mkp_sanitize_section_order( $input ) {
    $default_sections = mkp_get_default_section_order();
    
    if ( empty( $input ) ) {
        return implode( ',', $default_sections );
    }
    
    $sections = explode( ',', $input );
    $valid_sections = array();
    
    // Validate each section
    foreach ( $sections as $section ) {
        if ( in_array( $section, $default_sections ) ) {
            $valid_sections[] = $section;
        }
    }
    
    // Ensure all sections are present
    foreach ( $default_sections as $section ) {
        if ( ! in_array( $section, $valid_sections ) ) {
            $valid_sections[] = $section;
        }
    }
    
    return implode( ',', $valid_sections );
}

/**
 * Custom control for section ordering
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
    
class Mkp_Section_Order_Control extends WP_Customize_Control {
    
    public $type = 'section_order';
    
    /**
     * Enqueue scripts/styles
     */
    public function enqueue() {
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 
            'mkp-section-order', 
            get_template_directory_uri() . '/assets/js/section-order.js', 
            array( 'jquery', 'jquery-ui-sortable', 'customize-controls' ), 
            MKP_THEME_VERSION, 
            true 
        );
        
        wp_enqueue_style( 
            'mkp-section-order', 
            get_template_directory_uri() . '/assets/css/section-order.css', 
            array(), 
            MKP_THEME_VERSION 
        );
    }
    
    /**
     * Render the control
     */
    public function render_content() {
        // Get sections dynamically from the single source of truth
        $all_sections = mkp_get_all_sections_config();
        $sections = array();
        
        // Extract just the IDs and titles
        foreach ( $all_sections as $id => $config ) {
            $sections[ $id ] = $config['title'];
        }
        
        $current_order = mkp_get_section_order();
        ?>
        <?php if ( ! empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif; ?>
        <?php if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
        <?php endif; ?>
        
        <div class="mkp-section-order-container">
            <ul class="mkp-section-order-list" id="mkp-sortable-sections">
                <?php foreach ( $current_order as $section_id ) : 
                    if ( ! isset( $sections[ $section_id ] ) ) continue;
                    
                    // Check if section is fixed from configuration
                    $is_fixed = isset( $all_sections[ $section_id ]['fixed'] ) && $all_sections[ $section_id ]['fixed'];
                    
                    // Check if section is enabled
                    $is_enabled = true;
                    if ( ! $is_fixed ) {
                        $is_enabled = get_theme_mod( 'mkp_enable_section_' . $section_id, true );
                    }
                    
                    $item_classes = array( 'mkp-section-order-item' );
                    $item_classes[] = $is_fixed ? 'mkp-section-fixed' : 'mkp-section-sortable';
                    if ( ! $is_enabled ) {
                        $item_classes[] = 'mkp-section-disabled';
                    }
                    ?>
                    <li class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>" data-section="<?php echo esc_attr( $section_id ); ?>">
                        <span class="mkp-section-order-handle dashicons dashicons-menu"></span>
                        <span class="mkp-section-order-label"><?php echo esc_html( $sections[ $section_id ] ); ?></span>
                        <?php if ( $is_fixed ) : ?>
                            <span class="mkp-section-order-fixed"><?php esc_html_e( '(Fixed)', 'mediakit-lite' ); ?></span>
                        <?php elseif ( ! $is_enabled ) : ?>
                            <span class="mkp-section-order-status"><?php esc_html_e( '(Hidden)', 'mediakit-lite' ); ?></span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <input type="hidden" id="mkp-section-order-<?php echo esc_attr( $this->id ); ?>" class="mkp-section-order-input" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $current_order ) ); ?>" />
        </div>
        <?php
    }
}

} // End if class_exists