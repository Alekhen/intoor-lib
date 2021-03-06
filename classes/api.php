<?php
/**
 * This model contains methods that create, authorize, and return API
 * keys.
 *
 * @package     Интоор Library (intoor)
 * @author      Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright   2014 Hazard Media Group LLC
 * @license     MIT License - http://www.opensource.org/licenses/mit-license.html
 * @link        https://github.com/Alekhen/intoor-lib
 * @version     Release: 1.2
 */

if( !defined( 'INTOOR_RESTRICT_ACCESS' ) || !INTOOR_RESTRICT_ACCESS ) { die( 'Unauthorized Access' ); }

class API {

	public static $table = [
		'name' => 'api_keys',
		'prefix' => 'api',
		'version' => '1.0',
		'key' => INTOOR_API_KEY,
		'structure' => [
			'name' => [
				'sql' => 'VARCHAR(255)'
			],
			'api_key' => [
				'sql' => 'VARCHAR(255)',
				'encrypt' => true
			]
		]
	];

	public static function setup() {

		Database::install_table( static::$table );

	}

	public static function keygen( $min = 10000000, $max = 999999999 ) {

		$key = rand($min, $max);
		$key = Encryption::encrypt( $key );
		$key = str_replace( '/', '_', $key );
		$key = str_replace( '+', '_', $key );
		$key = str_replace( '=', '_', $key );
		return $key;

	}

	public static function new_key( $name ) {

		$data = Database::get_row( static::$table, 'name', strtolower( str_replace( ' ', '_', $name ) ) );
		
		return empty( $data['name'] ) ? Database::insert_row( static::$table, array( 'name' => $name, 'api_key' => static::keygen() ) ) : false;

	}

	public static function key_auth( $name, $key ) {

		$data = Database::get_row( static::$table, 'name', strtolower( str_replace( ' ', '_', $name ) ) );
		return ( !empty( $data['api_key'] ) && $data['api_key'] == $key ) ? true : false;

	}

	public static function get_key( $name ) {

		$data = Database::get_row( static::$table, 'name', strtolower( str_replace( ' ', '_', $name ) ) );
		return !empty( $data['api_key'] ) ? $data['api_key'] : '';

	}

	public static function key( $name ) {

		echo static::get_key( $name );

	}

}