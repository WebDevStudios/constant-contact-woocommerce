
/**
 * GuestCheckoutCapture.
 *
 * @package WebDevStudios\CCForWoo
 * @since   1.2.0
 */
export default class HandleSettingsPage {

    /**
     * @constructor
     *
     * @author Biplav Subedi <biplav.subedi@webdevstudios.com>
     * @since  ??
     */
    constructor() {
        this.els = {};
    }

    /**
     * Init ccWoo admin JS.
     *
     * @author Biplav Subedi <biplav.subedi@webdevstudios.com>
     * @since  ??
     */
    init() {
        this.cacheEls();
        this.bindEvents();
        this.enableStoreDetails();
    }

    /**
     * Cache some DOM elements.
     *
     * @author Biplav Subedi <biplav.subedi@webdevstudios.com>
     * @since  ??
     */
    cacheEls() {
        this.els.enableStoreDetails = document.getElementById( 'cc_woo_save_store_details' );
        this.els.optionalFields     = document.getElementById( 'cc-optional-fields' );

    }

    /**
     * Bind callbacks to events.
     *
     * @author Biplav Subedi <biplav.subedi@webdevstudios.com>
     * @since  ??
     */
    bindEvents() {
        this.els.enableStoreDetails.addEventListener( 'change', e => {
            this.enableStoreDetails();
        } );
    }

    /**
     * Captures guest checkout if billing email is valid.
     *
     * @author Biplav Subedi <biplav.subedi@webdevstudios.com>
     * @since  ??
     */
     enableStoreDetails() {
        if (this.els.enableStoreDetails.checked) {
            console.log(this.els.optionalFields.parentElement);
            this.els.optionalFields.parentElement.style.display = 'block';
          } else {
            this.els.optionalFields.parentElement.style.display = 'none';
        }
    }

}
