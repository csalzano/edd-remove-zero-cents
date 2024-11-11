<?php
/**
 * Plugin Name: Easy Digital Downloads - Remove Zero Cents
 * Plugin URI: https://github.com/csalzano/edd-remove-zero-cents
 * Description: Removes ".00" from download prices in USD currency
 * Version: 1.0.1
 * Author: Corey Salzano
 * Author URI: https://breakfastco.xyz
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * GitHub Plugin URI: csalzano/edd-remove-zero-cents
 * Primary Branch: main
 *
 * @package edd-remove-zero-cents
 */

defined( 'ABSPATH' ) || exit;

/**
 * Breakfast_EDD_Remove_Zero_Cents
 */
class Breakfast_EDD_Remove_Zero_Cents {

	/**
	 * This variable helps us know when we are outputting taxes in checkout.
	 *
	 * @var bool
	 */
	protected static $doing_taxes = false;

	/**
	 * Adds hooks that power the features.
	 *
	 * @return void
	 */
	public static function add_hooks() {
		// Only do this once.
		if ( has_filter( 'edd_format_amount_decimals', array( __CLASS__, 'remove_zero_cents' ) ) ) {
			return;
		}
		add_filter( 'edd_format_amount_decimals', array( __CLASS__, 'remove_zero_cents' ), 10, 2 );

		// Do not affect decimal places in tax detail lines in checkout.
		add_action( 'edd_checkout_table_tax_first', array( __CLASS__, 'taxes_start' ) );
		add_action( 'edd_checkout_table_tax_last', array( __CLASS__, 'taxes_stop' ) );
	}

	/**
	 * Calculates the number of decimals to use when formatting dollar amounts in
	 * Easy Digital Downloads.
	 *
	 * @param int        $decimals      Default 2. Number of decimals.
	 * @param int|string $amount        Amount being formatted.
	 * @return int  The number of decimals places to use when formatting the amount.
	 */
	public static function remove_zero_cents( $decimals, $amount ) {
		// Are we outputting taxes in checkout?
		if ( self::$doing_taxes ) {
			// Yes.
			return $decimals;
		}
		return ( '.00' === substr( $amount, -3 ) ) ? 0 : $decimals;
	}

	/**
	 * taxes_start
	 *
	 * @return void
	 */
	public static function taxes_start() {
		self::$doing_taxes = true;
	}

	/**
	 * taxes_stop
	 *
	 * @return void
	 */
	public static function taxes_stop() {
		self::$doing_taxes = false;
	}
}
Breakfast_EDD_Remove_Zero_Cents::add_hooks();
