/** Here are global function, usable on every page */

/** Copy the given text to clipboard and show a notification
 *
 * The notification must be in the page and in a span/div with an 
 * copied-to-cb HTML id.
 *
 * \param text The text to be copied to clipboard.
 *
 */
function copyToClipboard(text) {
    navigator.clipboard.writeText(text);
    $('#copied-to-cb').show().delay(3000).fadeOut(); //.removeAttr('hidden');
}
