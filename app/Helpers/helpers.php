<?php

// get domain extension from full url
function get_domain_extension( $domain ) {

	$parts = explode('.', $domain);

	return '.' . strtolower( end( $parts ));

}