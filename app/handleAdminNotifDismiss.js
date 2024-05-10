/**
 * GuestCheckoutCapture.
 *
 * @package WebDevStudios\CCForWoo
 * @since   1.2.0
 */
export default class HandleAdminNotifDismiss {

	/**
	 * @constructor
	 *
	 * @author Biplav Subedi <biplav.subedi@webdevstudios.com>
	 * @since 2.0.0
	 */
	constructor() {
		this.els = {};
	}

	/**
	 * Init ccWoo admin JS.
	 *
	 * @author Biplav Subedi <biplav.subedi@webdevstudios.com>
	 * @since 2.0.0
	 */
	init() {
		this.cacheEls();
		this.bindEvents();
	}

	/**
	 * Cache some DOM elements.
	 *
	 * @author Biplav Subedi <biplav.subedi@webdevstudios.com>
	 * @since 2.0.0
	 */
	cacheEls() {
		this.els.dismissNotification = document.querySelector('#cc-woo-review-dismiss');
	}

	/**
	 * Bind callbacks to events.
	 *
	 * @author Biplav Subedi <biplav.subedi@webdevstudios.com>
	 * @since 2.0.0
	 */
	bindEvents() {
		if (null !== this.els.dismissNotification) {
			const nonce = this.els.dismissNotification.dataset.nonce;
			const dismissbtn = this.els.dismissNotification.querySelector('.notice-dismiss');
			if (dismissbtn) {
				dismissbtn.addEventListener('click', e => {
					this.handleDismiss(nonce);
					e.preventDefault();
					this.els.dismissNotification.style.display = 'none';
				});
			}

			const alreadyReviewed = this.els.dismissNotification.querySelector('#already-reviewed');
			if (alreadyReviewed) {
				alreadyReviewed.addEventListener('click', e => {
					this.handleAlreadyReviewed(nonce);
					e.preventDefault();
					this.els.dismissNotification.style.display = 'none';
				});
			}
		}
	}

	handleDismiss( nonce ) {
		const url = cc_woo_ajax.ajax_url;
		const cc_woo_args = new URLSearchParams({
			action      : 'cc_woo_increment_dismissed_count',
			cc_woo_nonce: nonce,
		}).toString();

		const request = new XMLHttpRequest();

		request.open('POST', url, true);
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
		request.onload = function () {
			if (this.status >= 200 && this.status < 400) {
				console.log(this.response);
			} else {
				console.log(this.response);
			}
		};
		request.onerror = function () {
			console.log('update failed');
		};
		request.send(cc_woo_args);
	}

	handleAlreadyReviewed( nonce ) {
		const url = cc_woo_ajax.ajax_url;
		const cc_woo_args = new URLSearchParams({
			action      : 'cc_woo_set_already_reviewed',
			cc_woo_nonce: nonce,
		}).toString();

		const request = new XMLHttpRequest();

		request.open('POST', url, true);
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
		request.onload = function () {
			if (this.status >= 200 && this.status < 400) {
				console.log(this.response);
			} else {
				console.log(this.response);
			}
		};
		request.onerror = function () {
			console.log('update failed');
		};
		request.send(cc_woo_args);
	}

}
