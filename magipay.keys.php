<?php

$magipay_keys = array(" PLACE YOUR PRIVATE KEY HERE");	//Place your magipayment private key separated by comma. 
//EXAMPLE: $magipay_keys = array("private key 1","private key 2", .. so on);
 
define("MAGIPAY_PRIVATE_KEYS", implode(",", $magipay_keys));
unset($magipay_keys);

 ?>