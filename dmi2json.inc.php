<?php
// 
// dmi2Json 	(c) MMXVI John Soward <soward@soward.net>
// Released under the 3-clause BSD license. See LICENSE file.
// 
// Parses dmidecode output from Linux and friend and stuffs into a more useable JSON format
// Note that running dmidecode typically requires 'root' or similar priviledge. 
// it is wrapped with sudo -n here
// 
function dmiJson() {
	$jsonDMI = array();

	exec("sudo -n /usr/sbin/dmidecode", $dmiRaw, $rc);

	// ^Handle line starts a 'section'
	// then name of seection on a line
	// The Item: value
	// value may be > 1 line if item has multiple values.
	// Blank line ends block, expect Handle next.

	$inHandle = false;
	$inSection = false;
	$jsonDMI = array();
	$count = 0;

	foreach( $dmiRaw as $aLine) {
		
		$didMatchSection = false;

		if ( ! $inHandle ) {
			if ( preg_match("/^Handle/",$aLine) ) {
				$inHandle = true;
				continue; 							//No needed info here
			}
		}


		if ( strlen($aLine) < 3 ) {
			$inHandle = false;
			$inSection = false;
		}

		if ( $inHandle ) {

			if ( preg_match("/^End Of Table/",$aLine) ) {
				continue;								// Leave out the EoT maker.
			}

			preg_match("/([^.]+):([^.]+)/", $aLine, $matches);

			if ( isset($matches[1]) ) {
				$didMatchSection = true;
			}

			if ( ! $inSection && $didMatchSection ) {
				$inSection = true;
			}

			if ( ! $inSection ) {
				$currentHandle = trim($aLine);
				$jsonDMI[$currentHandle] = array();
				continue;							// Have all we need now
			}

			if ( $inSection ) {
				if ( $didMatchSection ) {
					$currentSection = trim($matches[1]);
					$jsonDMI[$currentHandle][$currentSection] = array();
					if ( isset($matches[2]) ) {
						$jsonDMI[$currentHandle][$currentSection][] = trim($matches[2]);
					}
				} else {
					$jsonDMI[$currentHandle][$currentSection][] = trim($aLine);
				}
			}
		}
	}
	return $jsonDMI;
}
