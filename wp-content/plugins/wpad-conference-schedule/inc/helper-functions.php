<?php
/**
 * Log
 *
 * @param mixed $message
 * @return void
 */
function wpcsp_log($message){
	$edac_log = dirname(__DIR__) . '/wpcsp_log.log';
	if (is_array($message) || is_object($message)) {
		$message = print_r($message, true);
	}
	if (file_exists($edac_log)) {
		$file = fopen($edac_log, 'a');
		fwrite($file, $message . "\n");
	} else {
		$file = fopen($edac_log, 'w');
		fwrite($file, $message . "\n");
	}
	fclose($file);
}
