<?php
/**
 * One-time migration that normalizes stored marketing opt-in values.
 *
 * Before this fix, the checkout block saved `cc_woo_customer_agrees_to_marketing` as a
 * PHP bool, which WordPress persisted as '1' (opted in) or '' (opted out). The classic
 * checkout, and every reader of the key, uses the strings 'true' / 'false'. This
 * migration rewrites the block-era values so all stored data uses one format.
 *
 * '' is safe to treat as an opt-out: the classic checkout never writes an empty value
 * (it returns early instead), so an empty value under this key can only come from the block.
 *
 * @package WebDevStudios\CCForWoo\Meta
 * @since   NEXT
 */

namespace WebDevStudios\CCForWoo\Meta;

use WebDevStudios\CCForWoo\View\Checkout\NewsletterPreferenceCheckbox;
use WebDevStudios\OopsWP\Structure\Service;

/**
 * Class OptInMetaMigration
 *
 * @package WebDevStudios\CCForWoo\Meta
 * @since   NEXT
 */
class OptInMetaMigration extends Service {

	/**
	 * Current version of the migration. Bump this to re-run it after future changes.
	 *
	 * @since NEXT
	 * @var string
	 */
	const VERSION = '1';

	/**
	 * Option that records which version of the migration has completed.
	 *
	 * @since NEXT
	 * @var string
	 */
	const VERSION_OPTION_NAME = 'cc_woo_opt_in_meta_migration_version';

	/**
	 * Legacy stored values mapped to their normalized replacement.
	 *
	 * '0' isn't written by the block path, but is mapped defensively.
	 *
	 * @since NEXT
	 * @var array
	 */
	const VALUE_MAP = [
		'1' => 'true',
		'0' => 'false',
		''  => 'false',
	];

	/**
	 * Register hooks with WordPress.
	 *
	 * @since NEXT
	 */
	public function register_hooks() {
		add_action( 'admin_init', [ $this, 'maybe_migrate' ] );
	}

	/**
	 * Run the migration if it hasn't completed for the current version yet.
	 *
	 * @since NEXT
	 */
	public function maybe_migrate() {
		if ( self::VERSION === get_option( self::VERSION_OPTION_NAME ) ) {
			return;
		}

		$this->migrate();

		update_option( self::VERSION_OPTION_NAME, self::VERSION, false );
	}

	/**
	 * Rewrite legacy values in user meta, legacy order post meta and HPOS order meta.
	 *
	 * Direct SQL is used on purpose: saving each order through the CRUD layer would fire
	 * `woocommerce_update_order` and any order webhooks for every historical order.
	 * The UPDATEs are idempotent, so a concurrent or repeated run is harmless.
	 *
	 * @since NEXT
	 */
	public function migrate() {
		global $wpdb;

		$this->migrate_table( $wpdb->usermeta, 'user_id', [ $this, 'clear_user_cache' ] );
		$this->migrate_table( $wpdb->postmeta, 'post_id', [ $this, 'clear_post_order_cache' ] );

		$hpos_table = $wpdb->prefix . 'wc_orders_meta';
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery -- One-time schema check.
		if ( $hpos_table === $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $hpos_table ) ) ) {
			$this->migrate_table( $hpos_table, 'order_id', [ $this, 'clear_hpos_order_cache' ] );
		}
	}

	/**
	 * Normalize legacy values in a single meta table.
	 *
	 * @since NEXT
	 *
	 * @param string   $table       Fully-prefixed meta table name.
	 * @param string   $object_col  Column holding the object ID.
	 * @param callable $clear_cache Callback receiving an object ID to invalidate.
	 */
	private function migrate_table( string $table, string $object_col, callable $clear_cache ) {
		global $wpdb;

		$meta_key = NewsletterPreferenceCheckbox::CUSTOMER_PREFERENCE_META_FIELD;

		// phpcs:disable WordPress.DB.PreparedSQL, WordPress.DB.DirectDatabaseQuery -- Table/column names are internal constants.
		foreach ( self::VALUE_MAP as $old => $new ) {
			$object_ids = [];

			// Only needed when meta caches outlive the request.
			if ( wp_using_ext_object_cache() ) {
				$object_ids = $wpdb->get_col(
					$wpdb->prepare(
						"SELECT DISTINCT {$object_col} FROM {$table} WHERE meta_key = %s AND meta_value = %s",
						$meta_key,
						$old
					)
				);
			}

			$wpdb->query(
				$wpdb->prepare(
					"UPDATE {$table} SET meta_value = %s WHERE meta_key = %s AND meta_value = %s",
					$new,
					$meta_key,
					$old
				)
			);

			foreach ( $object_ids as $object_id ) {
				$clear_cache( (int) $object_id );
			}
		}
		// phpcs:enable
	}

	/**
	 * Invalidate cached user meta.
	 *
	 * @since NEXT
	 *
	 * @param int $user_id User ID.
	 */
	public function clear_user_cache( int $user_id ) {
		wp_cache_delete( $user_id, 'user_meta' );
	}

	/**
	 * Invalidate cached meta for a post-table order.
	 *
	 * @since NEXT
	 *
	 * @param int $post_id Order post ID.
	 */
	public function clear_post_order_cache( int $post_id ) {
		wp_cache_delete( $post_id, 'post_meta' );
		$this->clear_hpos_order_cache( $post_id );
	}

	/**
	 * Invalidate WooCommerce's cached order object (HPOS caches meta on it).
	 *
	 * @since NEXT
	 *
	 * @param int $order_id Order ID.
	 */
	public function clear_hpos_order_cache( int $order_id ) {
		$cache_class = '\Automattic\WooCommerce\Caches\OrderCache';

		if ( ! function_exists( 'wc_get_container' ) || ! class_exists( $cache_class ) ) {
			return;
		}

		try {
			wc_get_container()->get( $cache_class )->remove( $order_id );
		} catch ( \Throwable $e ) {
			// Cache invalidation is best effort; the stored data is already correct.
			return;
		}
	}
}
