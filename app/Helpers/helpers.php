<?php
use \Carbon\Carbon;
// get domain extension from full url
function get_domain_extension( $domain ) {

	$parts = explode('.', $domain);

	return '.' . strtolower( end( $parts ));

}
//get the current dat time
function getCurrentDateTime() {
	$mytime = Carbon::now();
    return $mytime->toDateTimeString();
}