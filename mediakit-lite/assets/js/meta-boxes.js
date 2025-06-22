/**
 * Meta Boxes JavaScript
 */

(function($) {
    'use strict';
    
    /**
     * Repeater Field Functionality
     */
    $('.mkp-repeater').each(function() {
        const $repeater = $(this);
        const $container = $repeater.find('.mkp-repeater-items');
        const $addButton = $repeater.find('.mkp-add-item');
        const minItems = parseInt($repeater.attr('data-min')) || 1;
        const maxItems = parseInt($repeater.attr('data-max')) || 999;
        
        // Add new item
        $addButton.on('click', function(e) {
            e.preventDefault();
            
            const itemCount = $container.find('.mkp-repeater-item').length;
            
            if (itemCount >= maxItems) {
                alert('Maximum items reached');
                return;
            }
            
            const $newItem = $container.find('.mkp-repeater-item').first().clone();
            $newItem.find('input, textarea, select').val('');
            $container.append($newItem);
            
            updateRemoveButtons();
        });
        
        // Remove item
        $container.on('click', '.mkp-remove-item', function(e) {
            e.preventDefault();
            
            const itemCount = $container.find('.mkp-repeater-item').length;
            
            if (itemCount <= minItems) {
                alert('Minimum items required: ' + minItems);
                return;
            }
            
            $(this).closest('.mkp-repeater-item').remove();
            updateRemoveButtons();
        });
        
        // Update remove button visibility
        function updateRemoveButtons() {
            const itemCount = $container.find('.mkp-repeater-item').length;
            const $removeButtons = $container.find('.mkp-remove-item');
            
            if (itemCount <= minItems) {
                $removeButtons.prop('disabled', true);
            } else {
                $removeButtons.prop('disabled', false);
            }
        }
        
        updateRemoveButtons();
    });
    
    /**
     * Image Upload Field
     */
    $('.mkp-image-field').each(function() {
        const $field = $(this);
        const $input = $field.find('input[type="hidden"]');
        const $preview = $field.find('.mkp-image-preview');
        const $previewImg = $preview.find('img');
        const $addButton = $field.find('.mkp-add-image');
        const $removeButton = $field.find('.mkp-remove-image');
        
        // Open media library
        $addButton.on('click', function(e) {
            e.preventDefault();
            
            const mediaUploader = wp.media({
                title: mkpMetaBox.selectImage,
                button: {
                    text: mkpMetaBox.useImage
                },
                multiple: false
            });
            
            mediaUploader.on('select', function() {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                
                $input.val(attachment.id);
                $previewImg.attr('src', attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url);
                $preview.show();
            });
            
            mediaUploader.open();
        });
        
        // Remove image
        $removeButton.on('click', function(e) {
            e.preventDefault();
            
            $input.val('');
            $previewImg.attr('src', '');
            $preview.hide();
        });
    });
    
    /**
     * Gallery Field
     */
    $('.mkp-gallery-field').each(function() {
        const $field = $(this);
        const $container = $field.find('.mkp-gallery-images');
        const $addButton = $field.find('.mkp-add-gallery-images');
        
        // Make gallery sortable
        if ($.fn.sortable) {
            $container.sortable({
                items: '.mkp-gallery-item',
                cursor: 'move',
                placeholder: 'mkp-gallery-placeholder',
                update: function(event, ui) {
                    // Update input order
                    updateGalleryInputs();
                }
            });
        }
        
        // Open media library for multiple selection
        $addButton.on('click', function(e) {
            e.preventDefault();
            
            const mediaUploader = wp.media({
                title: mkpMetaBox.selectImages,
                button: {
                    text: mkpMetaBox.useImages
                },
                multiple: true
            });
            
            mediaUploader.on('select', function() {
                const attachments = mediaUploader.state().get('selection').toJSON();
                
                attachments.forEach(function(attachment) {
                    const $item = $('<div class="mkp-gallery-item" data-id="' + attachment.id + '">' +
                        '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" alt="" />' +
                        '<button type="button" class="mkp-remove-image">&times;</button>' +
                        '<input type="hidden" name="mkp_project_gallery[]" value="' + attachment.id + '" />' +
                        '</div>');
                    
                    $container.append($item);
                });
            });
            
            mediaUploader.open();
        });
        
        // Remove gallery image
        $container.on('click', '.mkp-remove-image', function(e) {
            e.preventDefault();
            $(this).closest('.mkp-gallery-item').remove();
        });
        
        // Update gallery input names
        function updateGalleryInputs() {
            $container.find('input[type="hidden"]').each(function(index) {
                $(this).attr('name', 'mkp_project_gallery[]');
            });
        }
    });
    
    /**
     * File Upload Field (PDF)
     */
    $('.mkp-file-field').each(function() {
        const $field = $(this);
        const $input = $field.find('input[type="hidden"]');
        const $preview = $field.find('.mkp-file-preview');
        const $fileName = $preview.find('.mkp-file-name');
        const $addButton = $field.find('.mkp-add-file');
        const $removeButton = $field.find('.mkp-remove-file');
        
        // Open media library for PDF
        $addButton.on('click', function(e) {
            e.preventDefault();
            
            const mediaUploader = wp.media({
                title: 'Select PDF',
                button: {
                    text: 'Use this PDF'
                },
                multiple: false,
                library: {
                    type: 'application/pdf'
                }
            });
            
            mediaUploader.on('select', function() {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                
                $input.val(attachment.id);
                $fileName.text(attachment.filename);
                $preview.show();
            });
            
            mediaUploader.open();
        });
        
        // Remove file
        $removeButton.on('click', function(e) {
            e.preventDefault();
            
            $input.val('');
            $fileName.text('');
            $preview.hide();
        });
    });
    
    /**
     * Validation for required fields
     */
    $('form#post').on('submit', function(e) {
        let isValid = true;
        const $form = $(this);
        
        // Check required text fields
        $form.find('.mkp-meta-box input[required], .mkp-meta-box textarea[required]').each(function() {
            const $field = $(this);
            
            if (!$field.val().trim()) {
                $field.addClass('error');
                isValid = false;
                
                // Add error message if not exists
                if (!$field.next('.mkp-error-message').length) {
                    $field.after('<span class="mkp-error-message">This field is required.</span>');
                }
            } else {
                $field.removeClass('error');
                $field.next('.mkp-error-message').remove();
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            
            // Scroll to first error
            const $firstError = $form.find('.error').first();
            if ($firstError.length) {
                $('html, body').animate({
                    scrollTop: $firstError.offset().top - 100
                }, 500);
            }
        }
    });
    
    // Clear error state on input
    $('.mkp-meta-box').on('input change', 'input.error, textarea.error', function() {
        $(this).removeClass('error');
        $(this).next('.mkp-error-message').remove();
    });
    
})(jQuery);