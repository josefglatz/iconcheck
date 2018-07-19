define([
    'jquery',
    'clipboardjs'
], function ($, clipboardjs) {
    'use strict';

    if ($('.t3js-clearable').length) {
        require(['TYPO3/CMS/Backend/jquery.clearable'], function() {
            $('.t3js-clearable').clearable();
        });
    }

    // Show copy functionality if it's supported by the browser
    if (clipboardjs.isSupported()) {
        var container = $('#container-content'),
            hiddenMarkupToShow = $('.show-when-copy-paste-supported');

        // add class for better UI styling if the feature is supported
        container.toggleClass('copy-paste-supported');
        // show hidden markup
        hiddenMarkupToShow.toggleClass('hidden');

        var clipboard = new clipboardjs('.click-to-copy');

        clipboard.on('success', function (e) {
            top.TYPO3.Notification.success(
                'Identifier copied to clipboard',
                '"' + e.text + '"'
            );

            e.clearSelection();
        });

        clipboard.on('error', function (e) {
            // Log event to console and disable the functionality completely
            console.error('Action:', e.action);
            console.error('Trigger:', e.trigger);
            top.TYPO3.Notification.error(
                'Copying identifier to clipboard failed',
                'The functionality was removed therefore. ' +
                'Please use your OS specific workflow to select ' +
                'and copy text in this module manually.'
            );
            clipboard.destroy();
            container.toggleClass('copy-paste-supported');
            hiddenMarkupToShow.toggleClass('hidden');
        });
    }

    // Add simple search functionality
    $(document).on('keyup', '#t3js-icon-search', function (e) {
        e.preventDefault();
        var that = $(this);
        setTimeout(function () {
            if (that.val() !== '') {
            	// Show only applicable items
                $('[data-icon-identifier]').show().not('[data-icon-identifier*="' + that.val() + '"]').hide();
            } else {
            	// Show all items if input field was cleared
                $('[data-icon-identifier]').show();
            }
            // Hide headers if none of it's icons is actually shown
            $('.icon-list').each(function () {
                var count = $('.icon-container:visible', this).length;
                if (count <= 0) {
                    $(this).prev().addClass('hidden');
                } else {
                    $(this).prev().removeClass('hidden');
                }
            });
        }, 200);
    });
});
