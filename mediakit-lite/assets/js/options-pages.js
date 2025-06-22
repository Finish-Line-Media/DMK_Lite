/**
 * Options Pages JavaScript
 */

(function($) {
    'use strict';
    
    // Copy meta-boxes.js functionality for options pages
    
    /**
     * Gallery Field for Options
     */
    $('.mkp-gallery-field').each(function() {
        const $field = $(this);
        const $container = $field.find('.mkp-gallery-images');
        const $addButton = $field.find('.mkp-add-gallery-images');
        const galleryName = $container.data('gallery');
        
        // Make gallery sortable
        if ($.fn.sortable) {
            $container.sortable({
                items: '.mkp-gallery-item',
                cursor: 'move',
                placeholder: 'mkp-gallery-placeholder'
            });
        }
        
        // Open media library for multiple selection
        $addButton.on('click', function(e) {
            e.preventDefault();
            
            const mediaUploader = wp.media({
                title: 'Select Images',
                button: {
                    text: 'Use these images'
                },
                multiple: true
            });
            
            mediaUploader.on('select', function() {
                const attachments = mediaUploader.state().get('selection').toJSON();
                
                attachments.forEach(function(attachment) {
                    const $item = $('<div class="mkp-gallery-item" data-id="' + attachment.id + '">' +
                        '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" alt="" />' +
                        '<button type="button" class="mkp-remove-image">&times;</button>' +
                        '<input type="hidden" name="' + galleryName + '[]" value="' + attachment.id + '" />' +
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
    });
    
    /**
     * Basic Repeater Field
     */
    $('.mkp-repeater').each(function() {
        const $repeater = $(this);
        const $container = $repeater.find('.mkp-repeater-items');
        const $addButton = $repeater.find('.mkp-add-item');
        const fieldName = $repeater.data('field-name');
        
        // Add new item
        $addButton.on('click', function(e) {
            e.preventDefault();
            
            const $newItem = $container.find('.mkp-repeater-item').first().clone();
            $newItem.find('input, textarea, select').val('');
            $container.append($newItem);
        });
        
        // Remove item
        $container.on('click', '.mkp-remove-item', function(e) {
            e.preventDefault();
            
            if ($container.find('.mkp-repeater-item').length > 1) {
                $(this).closest('.mkp-repeater-item').remove();
            } else {
                // Clear the last item instead of removing
                $(this).closest('.mkp-repeater-item').find('input, textarea, select').val('');
            }
        });
    });
    
    /**
     * Stats Repeater Field
     */
    $('.mkp-stats-repeater').each(function() {
        const $repeater = $(this);
        const $container = $repeater.find('.mkp-repeater-items');
        const $addButton = $repeater.find('.mkp-add-stats-item');
        const fieldName = $repeater.data('field-name');
        
        // Add new stat
        $addButton.on('click', function(e) {
            e.preventDefault();
            
            const newIndex = $container.find('.mkp-stats-item').length;
            const $newItem = $('<div class="mkp-repeater-item mkp-stats-item">' +
                '<input type="text" name="' + fieldName + '[' + newIndex + '][number]" value="" placeholder="Number" />' +
                '<input type="text" name="' + fieldName + '[' + newIndex + '][label]" value="" placeholder="Label" class="regular-text" />' +
                '<button type="button" class="button mkp-remove-item">Remove</button>' +
                '</div>');
            
            $container.append($newItem);
        });
        
        // Update indices when removing items
        $container.on('click', '.mkp-remove-item', function(e) {
            e.preventDefault();
            
            if ($container.find('.mkp-stats-item').length > 1) {
                $(this).closest('.mkp-stats-item').remove();
                
                // Reindex remaining items
                $container.find('.mkp-stats-item').each(function(index) {
                    $(this).find('input').each(function() {
                        const name = $(this).attr('name');
                        if (name) {
                            const newName = name.replace(/\[\d+\]/, '[' + index + ']');
                            $(this).attr('name', newName);
                        }
                    });
                });
            }
        });
    });
    
    /**
     * Media Logos Repeater Field
     */
    $('.mkp-media-logos-repeater').each(function() {
        const $repeater = $(this);
        const $container = $repeater.find('.mkp-repeater-items');
        const $addButton = $repeater.find('.mkp-add-logo-item');
        const fieldName = $repeater.data('field-name');
        
        // Add new logo
        $addButton.on('click', function(e) {
            e.preventDefault();
            
            const newIndex = $container.find('.mkp-media-logo-item').length;
            const $newItem = $('<div class="mkp-repeater-item mkp-media-logo-item">' +
                '<div class="mkp-logo-preview"><span>No logo</span></div>' +
                '<input type="hidden" name="' + fieldName + '[' + newIndex + '][logo]" value="" class="mkp-logo-id" />' +
                '<button type="button" class="button mkp-select-logo">Select Logo</button>' +
                '<input type="url" name="' + fieldName + '[' + newIndex + '][link]" value="" placeholder="Link (optional)" />' +
                '<button type="button" class="button mkp-remove-item">Remove</button>' +
                '</div>');
            
            $container.append($newItem);
        });
        
        // Select logo
        $container.on('click', '.mkp-select-logo', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const $item = $button.closest('.mkp-media-logo-item');
            const $preview = $item.find('.mkp-logo-preview');
            const $input = $item.find('.mkp-logo-id');
            
            const mediaUploader = wp.media({
                title: 'Select Logo',
                button: {
                    text: 'Use this logo'
                },
                multiple: false
            });
            
            mediaUploader.on('select', function() {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                
                $input.val(attachment.id);
                $preview.html('<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" alt="" />');
            });
            
            mediaUploader.open();
        });
        
        // Remove item
        $container.on('click', '.mkp-remove-item', function(e) {
            e.preventDefault();
            
            if ($container.find('.mkp-media-logo-item').length > 1) {
                $(this).closest('.mkp-media-logo-item').remove();
                
                // Reindex remaining items
                $container.find('.mkp-media-logo-item').each(function(index) {
                    $(this).find('input').each(function() {
                        const name = $(this).attr('name');
                        if (name) {
                            const newName = name.replace(/\[\d+\]/, '[' + index + ']');
                            $(this).attr('name', newName);
                        }
                    });
                });
            }
        });
    });
    
    /**
     * Links Repeater Field
     */
    $('.mkp-links-repeater').each(function() {
        const $repeater = $(this);
        const $container = $repeater.find('.mkp-repeater-items');
        const $addButton = $repeater.find('.mkp-add-link-item');
        const fieldName = $repeater.data('field-name');
        
        // Add new link
        $addButton.on('click', function(e) {
            e.preventDefault();
            
            const newIndex = $container.find('.mkp-link-item').length;
            const $newItem = $('<div class="mkp-repeater-item mkp-link-item">' +
                '<input type="text" name="' + fieldName + '[' + newIndex + '][title]" value="" placeholder="Title" />' +
                '<input type="url" name="' + fieldName + '[' + newIndex + '][link]" value="" placeholder="URL" class="regular-text" />' +
                '<button type="button" class="button mkp-remove-item">Remove</button>' +
                '</div>');
            
            $container.append($newItem);
        });
        
        // Remove item
        $container.on('click', '.mkp-remove-item', function(e) {
            e.preventDefault();
            
            if ($container.find('.mkp-link-item').length > 1) {
                $(this).closest('.mkp-link-item').remove();
                
                // Reindex remaining items
                $container.find('.mkp-link-item').each(function(index) {
                    $(this).find('input').each(function() {
                        const name = $(this).attr('name');
                        if (name) {
                            const newName = name.replace(/\[\d+\]/, '[' + index + ']');
                            $(this).attr('name', newName);
                        }
                    });
                });
            }
        });
    });
    
    /**
     * File Upload Field
     */
    $('.mkp-file-field').each(function() {
        const $field = $(this);
        const $input = $field.find('input[type="hidden"]');
        const $preview = $field.find('.mkp-file-preview');
        const $fileName = $preview.find('.mkp-file-name');
        const $addButton = $field.find('.mkp-add-file');
        const $removeButton = $field.find('.mkp-remove-file');
        const fileType = $addButton.data('type') || 'file';
        
        // Open media library for file
        $addButton.on('click', function(e) {
            e.preventDefault();
            
            const mediaConfig = {
                title: 'Select ' + fileType.toUpperCase(),
                button: {
                    text: 'Use this ' + fileType
                },
                multiple: false
            };
            
            if (fileType === 'pdf') {
                mediaConfig.library = {
                    type: 'application/pdf'
                };
            }
            
            const mediaUploader = wp.media(mediaConfig);
            
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
    
})(jQuery);