<?php
/**
 * Library configuration
 *
 * @package		Интоор Library (intoor)
 * @author		Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright	2014 Hazard Media Group LLC
 * @license		MIT License - http://www.opensource.org/licenses/mit-license.html
 * @link 		https://github.com/Alekhen/intoor-lib
 * @version		Release: 1.0
 */

// General library definitions
define( 'INTOOR_LIB_VERSION', '1.2' );
define( 'INTOOR_DIR_NAME', 'lib' );

// Encryption Keys
define( 'INTOOR_API_KEY', 'put your unique phrase here' );
define( 'INTOOR_MAIL_KEY', 'put your unique phrase here' );

// Define file and directory paths
require_once dirname( __FILE__ ) . '/paths.php';
require_once dirname( __FILE__ ) . '/load.php';