
import '@typo3/backend/input/clearable.js';
import DocumentService from '@typo3/core/document-service.js';
import DebounceEvent from '@typo3/core/event/debounce-event.js';

function search(el) {
    const text = (el.value + "").trim();

    // Toggle all icon-identifier elements if no search text or a match in the identifier
    document.querySelectorAll('[data-icon-identifier]').forEach((el) => {
        if (!text || (el.dataset.iconIdentifier + "").includes(text)) {
            el.classList.remove('hidden');
        } else {
            el.classList.add('hidden');
        }
    });
}

DocumentService.ready().then(() => {
    // Add hint to container
    const container = document.querySelector('#container-content');
    container.classList.add('copy-paste-supported');

    // Listen to bubbled clicks on container
    container.addEventListener("click", async (e) => {
        // Check if user clicked on a copy element
        const el = e.target.closest('.click-to-copy');

        // If copy element is found
        if (el) {
            // Write the clipboard text to the clipboard
            const text = el.dataset.clipboardText

            try {
                await navigator.clipboard.writeText(text)

                top.TYPO3.Notification.success(
                    'Identifier copied to clipboard',
                    '"' + text + '"'
                );
            } catch (err) {
                // On error, show a message
                console.error('Event:', e);
                console.error('Element:', el);
                console.error('Error:', err);
                top.TYPO3.Notification.error(
                    'Copying identifier to clipboard failed',
                    'The functionality was removed therefore. ' +
                    'Please use your OS specific workflow to select ' +
                    'and copy text in this module manually.'
                );
                // ... and remove hint
                container.classList.add('copy-paste-supported');
            }
        }
    });

    // Setup search box
    const searchbox = document.querySelector('#t3js-icon-search');
    const searcher = () => search(searchbox);

    // Make clearable
    try {
        searchbox.clearable({onClear: searcher});
    } catch (e) {
        console.error(e);
    }

    // Search on input
    new DebounceEvent('input', () => {
        searcher();
    }, 150).bindTo(searchbox);

    // Initial search if already loaded
    if (searchbox.value) {
        searcher();
    }
});
