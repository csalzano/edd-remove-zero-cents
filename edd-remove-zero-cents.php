<?php
defined( 'ABSPATH' ) or exit;

/**
 * Plugin Name: Easy Digital Downloads - Remove Zero Cents
 * Plugin URI: https://github.com/csalzano/edd-remove-zero-cents
 * Description: Removes ".00" from download prices in USD currency
 * Version: 1.0.0
 * Author: Corey Salzano
 * Author URI: https://breakfastco.xyz
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

add_filter( 'edd_format_amount_decimals', function( $decimals, $amount )
{
	return ( '.00' == substr( $amount, -3 ) ) ? 0 : $decimals;
}, 10, 2 );
