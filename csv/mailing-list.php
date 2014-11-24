<?php
/**
 * Mailing List CSV Generation File
 *
 * @package     Интоор Library (intoor)
 * @author      Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright   2014 Hazard Media Group LLC
 * @license     MIT License - http://www.opensource.org/licenses/mit-license.html
 * @link        https://github.com/Alekhen/intoor-lib
 * @version     Release: 1.2
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';
require_once dirname( dirname( __FILE__ ) ) . '/config.php';

// Verify encryption key
if( $_GET['key'] == get_option( 'mailing_list_key' ) ) :

	// Verify action is set to export
	if( $_GET['action'] == 'export' ) :

		// Define variables
		$counter = 0;
		$col_names = array();
		$csv = fopen( 'php://memory', 'w' );
		$data = ( !empty( $_GET['status'] ) ) ? Mailing_List::get_mailing_list( $_GET['status'] ) : Mailing_List::get_mailing_list();
		$delimiter = ( !empty( $_GET['delimiter'] ) ) ? $_GET['delimiter'] : ',';

		// Generate CSV lines
		foreach( $data as $line ) {
			if( $counter < 1 ) {
				foreach( $line as $col_name => $col_value ) {
					array_push( $col_names, $col_name );
				}
				fputcsv( $csv, $col_names, $delimiter );
			}
			fputcsv( $csv, $line, $delimiter );
			$counter++;
		}

		// Rewind the CSV file
		fseek( $csv, 0 );

		// Set CSV file headers
		header( 'Content-Type: application/csv' );
		header( 'Content-Disposition: attachement; filename="' . $_GET['file'] . '"' );

		// Send the generated CSV to the browser
		fpassthru( $csv );

	else :

		die( "Defined action is not supported." );

	endif;

else :

	die( "You do not have permission to access this page." );

endif;