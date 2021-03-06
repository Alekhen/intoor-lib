<?php
/**
 * This model creates creates and manages the interaction with cookies.
 *
 * @package     Интоор Library (intoor)
 * @author      Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright   2014 Hazard Media Group LLC
 * @license     MIT License - http://www.opensource.org/licenses/mit-license.html
 * @link        https://github.com/Alekhen/intoor-lib
 * @version     Release: 1.2
 */

if( !defined( 'INTOOR_RESTRICT_ACCESS' ) || !INTOOR_RESTRICT_ACCESS ) { die( 'Unauthorized Access' ); }

class Cookie {

	public $args = [
		'name' => 'intoor',    // Name of the cookie
		'domain' => '',        // Domain name of the site
		'path' => '/',         // The path inside which the cookie is available
		'expire' => '',        // Set the cookie's expiration (defaults to 10 years = 10 * 365 * 24 * 60 * 60)
		'encrypt' => false,    // Encrypt the data stored in the cookie or not (If encrypted JS will have no way to decript it)
		'key' => '',           // Encryption key used to encrypt and decrypt cookied data
		'secure' => false,     // Specifies whether the cookie can only be used across HTTPS connections
		'httponly' => false,   // The cookie can only be accessed through HTTP connections (Restricts JavaScript's access)
		'data' => array(),     // Array of data to be saved in the cookie
	];

	public function __construct( $args ) {

		$this->args = wp_parse_args( $args, $this->args );
		$this->args['domain'] = empty( $this->args['domain'] ) ? get_bloginfo( 'url' ) : $this->args['domain'];
		$this->args['expire'] = empty( $this->args['expire'] ) ? time() + 315360000 : $this->args['expire'];

		$this->setup_cookie();

	}

	protected function setup_cookie() {

		extract( $this->args );

		if( !isset( $_COOKIE[$name] ) ) :
		
			$data = ( $encrypt ) ? Encryption::encrypt( htmlentities( json_encode( $data ) ), $key ) : htmlentities( json_encode( $data ) );
			setcookie( $name, $data, $expire, $path, $domain, $secure, $httponly );

		endif;

	}

	public function get_data() {

		extract( $this->args );

		if( isset( $_COOKIE[$name] ) ) :

			return ( $encrypt ) ? json_decode( html_entity_decode( Encryption::decrypt( $_COOKIE[$name], $key ) ) ) : json_decode( html_entity_decode( $_COOKIE[$name] ) );

		else :

			return (object)$data;

		endif;

	}

	public function update( $new_data ) {

		extract( $this->args );

		$data = ( $encrypt ) ? Encryption::encrypt( htmlentities( json_encode( $new_data ) ), $key ) : htmlentities( json_encode( $new_data ) );
		setcookie( $name, $data, $expire, $path, $domain, $secure, $httponly );

	}

}