<?php
use \Carbon\Carbon;
use App\Models\Option;
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

function docusignHourDifference() {
	$toDate = Option::where('name','docusign_auth_code')->pluck('updated_at')->first();
	$to = Carbon::createFromFormat('Y-m-d H:s:i', $toDate);
	$from = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
	return $to->diffInHours($from);
}