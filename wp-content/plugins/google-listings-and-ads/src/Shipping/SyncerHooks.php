<?php
declare( strict_types=1 );

namespace Automattic\WooCommerce\GoogleListingsAndAds\Shipping;

use Automattic\WooCommerce\GoogleListingsAndAds\API\Google\Settings as GoogleSettings;
use Automattic\WooCommerce\GoogleListingsAndAds\Infrastructure\Registerable;
use Automattic\WooCommerce\GoogleListingsAndAds\Infrastructure\Service;
use Automattic\WooCommerce\GoogleListingsAndAds\Jobs\JobRepository;
use Automattic\WooCommerce\GoogleListingsAndAds\Jobs\UpdateShippingSettings;
use Automattic\WooCommerce\GoogleListingsAndAds\MerchantCenter\MerchantCenterService;

defined( 'ABSPATH' ) || exit;

/**
 * Class SyncerHooks
 *
 * Hooks to various WooCommerce and WordPress actions to automatically sync shipping settings.
 *
 * @package Automattic\WooCommerce\GoogleListingsAndAds\Shipping
 *
 * @since 2.1.0
 */
class SyncerHooks implements Service, Registerable {

	/**
	 * This property is used to avoid scheduling duplicate jobs in the same request.
	 *
	 * @var bool
	 */
	protected $already_scheduled = false;

	/**
	 * @var GoogleSettings
	 */
	protected $google_settings;

	/**
	 * @var MerchantCenterService
	 */
	protected $merchant_center;

	/**
	 * @var UpdateShippingSettings
	 */
	protected $update_shipping_job;

	/**
	 * SyncerHooks constructor.
	 *
	 * @param MerchantCenterService $merchant_center
	 * @param GoogleSettings        $google_settings
	 * @param JobRepository         $job_repository
	 */
	public function __construct( MerchantCenterService $merchant_center, GoogleSettings $google_settings, JobRepository $job_repository ) {
		$this->google_settings     = $google_settings;
		$this->merchant_center     = $merchant_center;
		$this->update_shipping_job = $job_repository->get( UpdateShippingSettings::class );
	}

	/**
	 * Register the service.
	 */
	public function register(): void {
		// only register the hooks if Merchant Center account is connected and the user has chosen for the shipping rates to be synced from WooCommerce settings.
		if ( ! $this->merchant_center->is_connected() || ! $this->google_settings->should_get_shipping_rates_from_woocommerce() ) {
			return;
		}

		$update_settings = function () {
			$this->handle_update_shipping_settings();
		};

		// After a shipping zone object is saved to database.
		add_action( 'woocommerce_after_shipping_zone_object_save', $update_settings, 90 );

		// After a shipping zone is deleted.
		add_action( 'woocommerce_delete_shipping_zone', $update_settings, 90 );

		// After a shipping method is added to or deleted from a shipping zone.
		add_action( 'woocommerce_shipping_zone_method_added', $update_settings, 90 );
		add_action( 'woocommerce_shipping_zone_method_deleted', $update_settings, 90 );

		// After a shipping method is enabled or disabled.
		add_action( 'woocommerce_shipping_zone_method_status_toggled', $update_settings, 90 );

		// After a shipping class is updated/deleted.
		add_action( 'woocommerce_shipping_classes_save_class', $update_settings, 90 );
		add_action( 'saved_product_shipping_class', $update_settings, 90 );
		add_action( 'delete_product_shipping_class', $update_settings, 90 );

		// After free_shipping and flat_rate method options are updated.
		add_action( 'woocommerce_update_options_shipping_free_shipping', $update_settings, 90 );
		add_action( 'woocommerce_update_options_shipping_flat_rate', $update_settings, 90 );

		// The shipping options can also be updated using other methods (e.g. by calling WC_Shipping_Method::process_admin_options).
		// Those methods may not fire any hooks, so we need to watch the base WordPress hooks for when those options are updated.
		$on_option_change = function ( $option ) {
			/**
			 * This Regex checks for the shipping options key generated by the `WC_Shipping_Method::get_instance_option_key` method.
			 * We check for the shipping method IDs supported by GLA (flat_rate or free_shipping), and an integer instance_id.
			 *
			 * @see \WC_Shipping_Method::get_instance_option_key for more information about this key.
			 */
			if ( preg_match( '/^woocommerce_(flat_rate|free_shipping)_\d+_settings$/', $option ) ) {
				$this->handle_update_shipping_settings();
			}
		};
		add_action(
			'updated_option',
			$on_option_change,
			90
		);
		add_action(
			'added_option',
			$on_option_change,
			90
		);
	}

	/**
	 * Handle updating of Merchant Center shipping settings.
	 *
	 * @return void
	 */
	protected function handle_update_shipping_settings() {
		// Bail if an event is already scheduled in the current request
		if ( $this->already_scheduled ) {
			return;
		}
		$this->update_shipping_job->schedule();
		$this->already_scheduled = true;
	}
}
