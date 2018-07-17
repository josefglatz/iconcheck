define([
    'jquery',
    'clipboardjs'
], function ($, clipboardjs) {
    'use strict';

    // Show copy functionality if it's supported by the browser
    if(clipboardjs.isSupported()) {
        var container = $('#container-content'),
            hiddenMarkupToShow = $('.show-when-copy-paste-supported');

        // add class for better UI styling if the feature is supported
        container.toggleClass('copy-paste-supported');
        // show hidden markup
        hiddenMarkupToShow.toggleClass('hidden');

        var clipboard = new clipboardjs('.click-to-copy');

        clipboard.on('success', function(e) {
            top.TYPO3.Notification.success(
                'Identifier copied to clipboard',
                '"' + e.text + '"'
            );

            e.clearSelection();
        });

        clipboard.on('error', function(e) {
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
});
