define([
    'jquery',
    'clipboardjs'
], function ($, clipboardjs) {
    'use strict';

    var container = $('#container-content'),
        hiddenMarkupToShow = $('.show-when-copy-paste-supported');

    // Show copy functionality if it's supported by the browser
    if(clipboardjs.isSupported()) {

        // initialize UI
        adoptUI();

        var clipboard = new clipboardjs('.click-to-copy');

        // Show feedback on success
        clipboard.on('success', function(e) {
            top.TYPO3.Notification.success(
                'Identifier copied to clipboard',
                '"' + e.text + '"'
            );

            e.clearSelection();
        });

        // Log event to console and disable the functionality completely
        clipboard.on('error', function(e) {

            console.error('Action:', e.action);
            console.error('Trigger:', e.trigger);

            top.TYPO3.Notification.error(
                'Copying identifier to clipboard failed',
                'The functionality was removed therefore. ' +
                'Please use your OS specific workflow to select ' +
                'and copy text in this module manually.'
            );

            // Disable clipboard.js functionality
            clipboard.destroy();
            // uninitialize UI
            adoptUI();
        });
    }

    /**
     * Adopt UI markup which is used on
     * - initialization
     * - and if the copy to clipboard functionality has errors
     */
    function adoptUI() {
        container.toggleClass('copy-paste-supported');
        hiddenMarkupToShow.toggleClass('hidden');
    }
});
