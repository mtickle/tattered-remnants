//! Version: 1.6

// jQuery formatted selector to search for focusable items
var focusableElementsString = "a[href], button:not([disabled])";

// Store the item that has focus before opening the menu modal
var focusedElementBeforeModal;

jQuery(document).ready(function ($) {
	NProgress.start();

	// Main menu
	$('#nav-toggle').click(function(e) {
		showModal($('#menu-modal'));
	});
	$('#nav-close').click(function(e) {
		hideModal();
	});
	$('#menu-modal').keydown(function(event) {
		trapTabKey($(this), event);
		trapEscapeKey($(this), event);
	})
});

jQuery(window).on('load', function () {
	NProgress.done();
});

function trapEscapeKey(obj, evt) {
	// if escape pressed
	if (evt.which === 27) {

		// get list of all children elements in given object
		var o = obj.find('*');

		// close the modal window
		evt.preventDefault();
	}
}

function trapTabKey(obj, evt) {
	// if tab or shift-tab pressed
	if (evt.which === 9) {

		// get list of all children elements in given object
		var o = obj.find('*');

		// get list of focusable items
		var focusableItems;
		focusableItems = o.filter(focusableElementsString).filter(':visible')

		// get currently focused item
		var focusedItem;
		focusedItem = jQuery(':focus');

		// get the number of focusable items
		var numberOfFocusableItems;
		numberOfFocusableItems = focusableItems.length

		// get the index of the currently focused item
		var focusedItemIndex;
		focusedItemIndex = focusableItems.index(focusedItem);

		if (evt.shiftKey) {
			//back tab
			// if focused on first item and user preses back-tab, go to the last focusable item
			if (focusedItemIndex === 0) {
				focusableItems.get(numberOfFocusableItems - 1).focus();
				evt.preventDefault();
			}

		} else {
			// forward tab
			// if focused on the last item and user preses tab, go to the first focusable item
			if (focusedItemIndex === numberOfFocusableItems - 1) {
				focusableItems.get(0).focus();
				evt.preventDefault();
			}
		}
	}
}

function setInitialFocusModal(obj) {
	// get list of all children elements in given object
	var o = obj.find('*');

	// set focus to first focusable item
	var focusableItems;
	focusableItems = o.filter(focusableElementsString).filter(':visible').first().focus();
}

function setFocusToFirstItemInModal(obj){
	// get list of all children elements in given object
	var o = obj.find('*');

	// set the focus to the first keyboard focusable item
	o.filter(focusableElementsString).filter(':visible').first().focus();
}

function showModal(obj) {
	jQuery('#page').attr('aria-hidden', 'true'); // mark the main page as hidden
	jQuery('#modalOverlay').css('display', 'block'); // insert an overlay to prevent clicking and make a visual change to indicate the main page is not available
	let menuModal = jQuery('#menu-modal');
	menuModal.css('display', 'block');
	menuModal.attr('aria-hidden', 'false'); // mark the modal window as visible

	// save current focus
	focusedElementBeforeModal = jQuery(':focus');

	setFocusToFirstItemInModal(obj);
}

function hideModal() {
	jQuery('#modalOverlay').css('display', 'none'); // remove the overlay in order to make the main screen available again
	let menuModal = jQuery('#menu-modal');
	menuModal.css('display', 'none');
	menuModal.attr('aria-hidden', 'true'); // mark the modal window as hidden
	jQuery('#page').attr('aria-hidden', 'false'); // mark the main page as visible

	// remove the listener which redirects tab keys in the main content area to the modal
	jQuery('body').off('focusin','#page');

	// set focus back to element that had it before the modal was opened
	focusedElementBeforeModal.focus();
}