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
	if(isset($toDate)) {
		$to = Carbon::createFromFormat('Y-m-d H:s:i', $toDate);
		$from = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
		return $to->diffInHours($from);
	}
	return false;
}

function changeDateFormat($date) {
	return date("F d, Y h:i a", strtotime($date));

}

function formatMobileNumber($formattedNumber) {
	return preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $formattedNumber);
}